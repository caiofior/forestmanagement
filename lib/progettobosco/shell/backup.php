<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
switch ($DB_CONFIG['adapter']) {
    case 'Pgsql':
        echo exec ('sudo -u '.$DB_CONFIG['username'].' psql '.$DB_CONFIG['dbname'].' -c "
        SELECT  \'SELECT SETVAL(\' ||quote_literal(S.relname)|| \', MAX(\' ||quote_ident(C.attname)|| \') ) FROM \' ||quote_ident(T.relname)|| \';\'
        FROM pg_class AS S, pg_depend AS D, pg_class AS T, pg_attribute AS C
        WHERE S.relkind = \'S\'
            AND S.oid = D.objid
            AND D.refobjid = T.oid
            AND D.refobjid = C.attrelid
            AND D.refobjsubid = C.attnum
        ORDER BY S.relname;    
        " -t -o '.__DIR__.DIRECTORY_SEPARATOR.'fix_seqa.sql');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' sed -e \'s/\(.*\)/\L\1/\' '.__DIR__.DIRECTORY_SEPARATOR.'fix_seqa.sql > '.__DIR__.DIRECTORY_SEPARATOR.'fix_seq.sql');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' psql '.$DB_CONFIG['dbname'].' < '.__DIR__.DIRECTORY_SEPARATOR.'fix_seq.sql;');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' pg_dump '.$DB_CONFIG['dbname'].' > '.__DIR__.DIRECTORY_SEPARATOR.'pg_'.$DB_CONFIG['dbname'].'.sql;');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' rm -f '.__DIR__.DIRECTORY_SEPARATOR.'fix_seqa.sql;');
        echo exec ('sudo -u '.$DB_CONFIG['username'].' rm -f '.__DIR__.DIRECTORY_SEPARATOR.'fix_seq.sql;');
    break;
    case 'Mysqli':
        $pass = '';
        if ($DB_CONFIG['password'] != '')
            $pass = ' -p'.$DB_CONFIG['password'];
        echo exec ('mysqldump -u '.$DB_CONFIG['username'].$pass.' '.$DB_CONFIG['dbname'].' > '.__DIR__.DIRECTORY_SEPARATOR.'mysql_'.$DB_CONFIG['dbname'].'.sql;');
    break;
}

