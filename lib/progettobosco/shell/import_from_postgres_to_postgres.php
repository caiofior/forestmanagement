<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
require (__DIR__.DIRECTORY_SEPARATOR.'table_order.php');
if ($argc < 1) {
    echo 'postgres origin is required';
    exit;
}
$config = <<<EOL
[pgsql]     
host = '{$DB_CONFIG['host']}'
port = {$DB_CONFIG['port']}        
base = '{$DB_CONFIG['dbname']}'
user = '{$DB_CONFIG['username']}'
pass = '{$DB_CONFIG['password']}'
log_file            = pgloader.log
client_min_messages = ERROR
copy_every      = 100

[tmpl]
template     = True
format       = text
field_sep    = ,


EOL;
if(!is_dir($dir.'output'))
    mkdir ($dir.'output');
$or_config = $DB_CONFIG;
$or_config['dbname']=$argv[1];
$db_or = Zend_Db::factory($DB_CONFIG['adapter'],$or_config);
$db_or->getConnection();

foreach ($tables as $table) {
    $filename = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.txt';
    $filename_t = $dir.'output'.DIRECTORY_SEPARATOR.$table.'_t.txt';
    $logname = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.log';
    $dataname = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.data';
    $pgloader = $dir.'pgloader.conf';
    if (is_file($filename)) unlink($filename);
    if (is_file($logname)) unlink($logname);
    if (is_file($dataname)) unlink($dataname);
    $dest_cols = $db->fetchCol('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$table.'\'');
    $dest_cols = array_reverse($dest_cols);
    $or_cols = $db_or->fetchCol('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$table.'\'');
    $or_cols = array_reverse($or_cols);
    $columns_str='';
    foreach ($dest_cols as $dest_col) {
        $key = array_search($dest_col, $or_cols);
        if ($key === false) continue;
        if ($columns_str != '')
            $columns_str .= ',';
        $columns_str .= $dest_col.':'.($key+1);        
    }
    $max_objectid=0;
    $rc = 1;
    exec('sudo -u '.$DB_CONFIG['username'].' psql '.$argv[1].' -c "COPY '.$table.' TO \''.$filename.'\' WITH CSV "');
    if ( in_array($table, $preserveid) && 
            in_array('objectid', $or_cols)) {
        $file_input = fopen($filename, 'r');
        $file_output = fopen ($filename_t,'w');
        $key_field = array_search('objectid', $or_cols);
        $max_objectid=  $db->fetchOne('SELECT MAX(objectid) FROM '.$table);
        $p=0;
        while ($row = fgets($file_input)) {
            fseek($file_input, $p);
            $row_csv = fgetcsv($file_input,0,',','"');
            $value = $row_csv[$key_field];
            $row = str_replace(','.$value.',', ','.($rc).',', $row);
            $row = preg_replace('/,'.$value.'$/', ','.($rc), $row);
            fputs($file_output,$row);
            $p = ftell($file_input);
            $max_objectid = max($max_objectid,$rc);
            $rc++;
        }
        if (is_resource($file_input))
            fclose($file_input);
        fclose($file_output);
    } 
    else copy($filename,$filename_t);
    file_put_contents($pgloader, $config. <<<EOL

[{$table}]
use_template    = tmpl
table           = {$table}
filename = {$filename_t}
columns = {$columns_str}
reject_log = {$dir}output/{$argv[1]}_{$table}.log
reject_data = {$dir}output/{$argv[1]}_{$table}.data

EOL
);
if ( in_array($table, $preserveid) && 
        in_array('objectid', $or_cols)) {
    $db->query('UPDATE '.$table.' SET objectid = objectid + '.intval($max_objectid));
 }
    exec('pgloader -c '.$pgloader.' '.$table);
    if ( in_array($table, $preserveid) && 
        in_array('objectid', $or_cols)) {
     $max_objectid=  max(0,$db->fetchOne('SELECT MAX(objectid) FROM '.$table));
     $db->query('UPDATE '.$table.' SET objectid = objectid+'.$max_objectid);
     $db->query('SELECT setval(\''.$table.'_objectid_seq\', 1)');
     $db->query('UPDATE '.$table.' SET objectid = DEFAULT');
     $db->query('VACUUM '.$table);
     $db->query('REINDEX TABLE '.$table);
}
if (is_file($pgloader)) unlink($pgloader);
if (is_file($filename)) unlink($filename);
if (is_file($filename_t)) unlink($filename_t);
$error = file_exists($logname) && filesize($logname) > 0;
if (is_file($logname) && !$error) unlink($logname);
if (is_file($dataname) && !$error) unlink($dataname);
}
$db->query('
DELETE FROM leg_note  WHERE objectid IN (
SELECT MAX(objectid) FROM leg_note AS n 

	WHERE (
	SELECT COUNT(*) FROM leg_note AS n1 
	WHERE LOWER(n1.archivio)=LOWER(n.archivio)
	AND LOWER(n1.nomecampo)=LOWER(n.nomecampo)
	) > 1
	GROUP BY (UPPER(archivio), UPPER(nomecampo))
	)
');