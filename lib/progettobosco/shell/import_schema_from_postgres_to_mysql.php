<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
require (__DIR__.DIRECTORY_SEPARATOR.'table_order.php');
if(!is_dir($dir.'output'))
    mkdir ($dir.DIRECTORY_SEPARATOR.'output');
if ($argc < 5) {
    echo 'Mysql connection is required';
    exit;
}
$db1 = $argv;
echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump --schema-only --format p --inserts '.$DB_CONFIG['dbname'].' > '.$dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql;');
$text = file_get_contents($dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql');
$text = preg_replace('/CREATE EXTENSION.*AS IMPLICIT/ms', '', $text);
file_put_contents($dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql', $text);
$argv[1]=$dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql';
$argv[2]=$dir.'output'.DIRECTORY_SEPARATOR.'mysql_schema.sql';    
require $dir.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pg2mysql-1.9'.DIRECTORY_SEPARATOR.'pg2mysql_cli.php' ;
$pass = '';
if ($db1[3] != '') $pass = ' -p'.$db1[3];
echo exec ('mysqladmin -h '.$db1[1].' -u '.$db1[2].$pass.' -f DROP '.$db1[4]);
echo exec ('mysqladmin -h '.$db1[1].' -u '.$db1[2].$pass.' CREATE '.$db1[4]);
echo exec ('mysql -h '.$db1[1].' -u '.$db1[2].$pass.' '.$db1[4].' --force < '.$dir.'output'.DIRECTORY_SEPARATOR.'mysql_schema.sql');
unlink ($dir.'output'.DIRECTORY_SEPARATOR.'pg_schema.sql');
unlink ($dir.'output'.DIRECTORY_SEPARATOR.'mysql_schema.sql');
$sql = "
 CREATE TABLE `geo_particellare` (
  `id_av` varchar(12) NOT NULL,
  `poligon` geometry DEFAULT NULL,
  `zone` varchar(3) DEFAULT NULL,
 PRIMARY KEY (`id_av`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1";
echo exec('mysql -h '.$db1[1].' -u '.$db1[2].$pass.' '.$db1[4].' -e"'.$sql.'"');
echo exec('mysql -h '.$db1[1].' -u '.$db1[2].$pass.' '.$db1[4].' -e"ALTER TABLE propriet 
CHANGE COLUMN objectid  objectid int(11),
DROP PRIMARY KEY, ADD PRIMARY KEY(codice);"');
$all_tables = $db->fetchCol('SELECT table_name FROM information_schema.tables WHERE table_schema=\'public\'');
$common_table = array_diff($all_tables, $preserveid);
$all_tables = array_merge($common_table, $preserveid);
foreach ($all_tables as $table) {
    $filename_or = $dir.'output'.DIRECTORY_SEPARATOR.$table.'_or.csv';
    $filename = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.csv';
    exec('sudo -u '.$DB_CONFIG['username'].' psql '.$DB_CONFIG['dbname'].' -c "COPY \"'.$table.'\" TO \''.$filename_or.'\' WITH CSV "');
    $file_input = fopen($filename_or,'r');
    $file_output = fopen($filename,'w');
    while ($row = fgets($file_input)) {
        while (strpos($row,',t,' ) !== false)
            $row = str_replace(',t,', ',1,', $row);
        $row = preg_replace('/^t,/', '1,', $row);
        $row = preg_replace('/,t$/', ',1', $row);
        fputs($file_output,$row);
    }
    fclose($file_input);
    fclose($file_output);
    echo exec('mysqlimport -h '.$db1[1].' -u '.$db1[2].$pass.' --local --fields-terminated-by="," --fields-enclosed-by="" '.$db1[4].' '.$filename).PHP_EOL;
    if (is_file($filename_or))
        unlink($filename_or);
    if (is_file($filename))
        unlink($filename);
}

