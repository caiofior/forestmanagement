<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Page boot actions, requirments ad db connection
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'config.php');
$BASE_DIR = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR;
header('Content-type: text/html; charset=utf-8');
/**
 * Includes monitoring script
 */
if ((!isset($PHPUNIT) || !$PHPUNIT) && (isset($MONITORING) && $MONITORING))
    require (__DIR__.DIRECTORY_SEPARATOR.'monitoring.php');
/**
 * Include paths
 */
if (isset($ZEND_PATH))
    set_include_path(get_include_path().PATH_SEPARATOR.$ZEND_PATH);
if (isset($PEAR_PATH))
    set_include_path(get_include_path().PATH_SEPARATOR.$PEAR_PATH);
set_include_path(get_include_path().PATH_SEPARATOR.__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib');
/**
 * Config debug options
 */
ini_set('memory_limit', '128M');
ini_set('session.gc_probability',0);
if (isset($DEBUG) && $DEBUG) {
    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors', 1);
    ini_set('xdebug.collect_vars', 0);
    ini_set('xdebug.collect_params', 0);
    ini_set('xdebug.dump_globals', 0);
    ini_set('xdebug.show_local_vars', 0);
    if (!(isset($PHPUNIT) && $PHPUNIT)) {
        ini_set('html_errors',1);
        ini_set('xdebug.show_local_vars', 1);
        
    }
}
/**
 * Loads forest progetto bosco module
 */
require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb'.DIRECTORY_SEPARATOR.'forest'.DIRECTORY_SEPARATOR.'autoloader.php') ;
$log = new Log();
// Manages session
require(__DIR__.DIRECTORY_SEPARATOR.'session.php');