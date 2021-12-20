<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
switch ($DB_CONFIG['adapter']) {
    case 'Pgsql':
        echo exec ('sudo -u '.$DB_CONFIG['username'].' psql -c "DROP DATABASE '.$DB_CONFIG['dbname'].';"');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' psql -c "CREATE DATABASE '.$DB_CONFIG['dbname'].';"');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' psql '.$DB_CONFIG['dbname'].' < '.__DIR__.DIRECTORY_SEPARATOR.'pg_'.$DB_CONFIG['dbname'].'.sql;');
           break;
    case 'Mysqli':
        $pass = '';
        if ($DB_CONFIG['password'] != '')
            $pass = ' -p'.$DB_CONFIG['password'];
        echo exec ('mysqladmin -u '.$DB_CONFIG['username'].$pass.' -f drop '.$DB_CONFIG['dbname']);
        echo exec ('mysqladmin -u '.$DB_CONFIG['username'].$pass.' create '.$DB_CONFIG['dbname']);
        echo exec ('mysql -u '.$DB_CONFIG['username'].$pass.' '.$DB_CONFIG['dbname'].' < '.__DIR__.DIRECTORY_SEPARATOR.'mysql_'.$DB_CONFIG['dbname'].'.sql;');
    break;
}