<?php
$dir = __DIR__.DIRECTORY_SEPARATOR;
$tables = exec('mdb-tables '.$argv[1]);
$tables = explode(' ', $tables);
foreach ($tables as $table) {
    $filename = $dir.'output'.DIRECTORY_SEPARATOR.$table.'.txt';
    exec('mdb-export -D "%Y-%m-%d %H:%M:%S" '.$argv[1].' '.$table.' > '.$filename);
}