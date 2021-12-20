<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
require (__DIR__.DIRECTORY_SEPARATOR.'table_order.php');
if ($argc < 1) {
    echo 'MDB path is required';
    exit;
} else if ($argc > 2) {
    foreach ($argv as $key=>$value) {
        if ($key == 0) continue;
        else $argv[1].='\\ '.$value;
        
    }
}
$config = <<<EOL
[pgsql]     
host = '{$DB_CONFIG['host']}'
port = {$DB_CONFIG['port']}        
base = '{$DB_CONFIG['dbname']}'
user = '{$DB_CONFIG['username']}'
pass = '{$DB_CONFIG['password']}'
log_file            = pgloader.log
log_min_messages    = INFO
client_min_messages = ERROR
copy_every      = 100

[tmpl]
template     = True
format       = csv
field_sep    = ,
trailing_sep = True

EOL;
if(!is_dir(__DIR__.DIRECTORY_SEPARATOR.'output'))
    mkdir (__DIR__.DIRECTORY_SEPARATOR.'output');

foreach ($tables as $table) {
    $filename = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.txt';
    $filename_t = $dir.'output'.DIRECTORY_SEPARATOR.$table.'_t.txt';
    $logname = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.log';
    $dataname = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.data';
    $pgloader = $dir.'pgloader.conf';
    if (is_file($filename)) unlink($filename);
    if (is_file($filename_t)) unlink($filename_t);
    if (is_file($logname)) unlink($logname);
    if (is_file($dataname)) unlink($dataname);
    exec('mdb-export -D "%Y-%m-%d %H:%M:%S" '.$argv[1].' '.$table.' > '.$filename);
    $filepart = dirname($argv[1]);
    $filepart = explode(DIRECTORY_SEPARATOR, $filepart);
    $filepart = array_pop($filepart);
    $file_input = fopen ($filename,'r');
    $file_output = fopen ($filename_t,'w');
    $p = ftell($file_input);
    $columns_str = '';
    $key_field = null;
    $max_objectid=0;
    if (is_resource($file_input)) {
        $rc = 0;
        while ($row = fgets($file_input)) {
            if ($p == 0) {
                $db_cols = $db->fetchCol('SELECT column_name FROM information_schema.columns WHERE table_name =\''.$table.'\'');
                $db_cols = array_reverse($db_cols);
                $columns = str_replace("\n",'',strtolower($row));
                $columns = explode(',',$columns);
                foreach ($db_cols as $db_col) {
                    $key = array_search($db_col, $columns);
                    if ($key === false) continue;
                    if ($columns_str != '')
                        $columns_str .= ',';
                    $columns_str .= $db_col.':'.($key+1);        
                }
                if ( in_array($table, $preserveid) && 
                        in_array('objectid', $columns)) {
                    $key_field = array_search('objectid', $columns);
                    $max_objectid=  $db->fetchOne('SELECT MAX(objectid) FROM '.$table);
                }

            }
            else {
                preg_match_all('/[0-9]\.[0-9]*e\+[0-9]{2}/', $row,$e_matches);
                if (key_exists(0, $e_matches)) {
                    foreach($e_matches[0] as $e_match) {
                        $row = str_replace($e_match, floatval($e_match), $row);
                    }
                }
                if ( in_array($table, $preserveid) && 
                        in_array('objectid', $columns)) {
                    fseek($file_input, $p);
                    $row_csv = fgetcsv($file_input,0,',','"');
                    $value = $row_csv[$key_field];
                    $row = str_replace(','.$value.',', ','.($rc).',', $row);
                    $row = preg_replace('/,'.$value.'$/', ','.($rc), $row);
                        
                    $max_objectid = max($max_objectid,$rc);
                    
                }
                fputs($file_output,$row);
            }
            $p = ftell($file_input);
            $rc++;
        }
        fclose($file_input);
        fclose($file_output);
    }
file_put_contents($pgloader, $config. <<<EOL

[{$table}]
use_template    = tmpl
table           = {$table}
filename = {$filename_t}
columns = {$columns_str}
reject_log = {$dir}output/{$filepart}_{$table}.log
reject_data = {$dir}output/{$filepart}_{$table}.data

EOL
);
if ( in_array($table, $preserveid) && 
    in_array('objectid', $columns)) {
    $db->query('UPDATE '.$table.' SET objectid = objectid + '.intval($max_objectid));
 }
exec('pgloader -c '.$pgloader.' '.$table);
if ( in_array($table, $preserveid)
    && in_array('objectid', $columns)) {
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