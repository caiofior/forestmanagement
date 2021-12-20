<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
require (__DIR__.DIRECTORY_SEPARATOR.'table_order.php');
$all_tables = $db->fetchCol('SELECT table_name FROM information_schema.tables WHERE table_schema=\'public\'');

foreach($all_tables as $table) {
    echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump '.$DB_CONFIG['dbname'].' --data-only -t '.$table.' > '.__DIR__.DIRECTORY_SEPARATOR.'output'.DIRECTORY_SEPARATOR.'pg_'.$table.'.sql;');
}


