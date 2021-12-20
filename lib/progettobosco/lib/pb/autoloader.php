<?php
/**
 * Autoloading files
 * 
 * Autoloading files
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
if (!class_exists('AutoLoader')) {
    /**
     * Class that load required files
     */
    final class AutoLoader {

        /**
         * Reference to static instance
         * @var \AutoLoader
         */
        private static $instance = null;

        /**
         * Module files
         * @var array
         */
        private static $module_files = array();

        /**
         * Instantiares the main loading class
         */
        private function __construct() {
            include('Zend' . DIRECTORY_SEPARATOR . 'Loader.php');
            if (!class_exists('Zend_Loader'))
                throw new \Exception('ZendFramework is required and must be pointed by $ZEND_PATH config variable');

            if (key_exists('DEBUG', $GLOBALS) && $GLOBALS['DEBUG']) {
                include('FirePHPCore' . DIRECTORY_SEPARATOR . 'fb.php');
                if (!class_exists('FirePHP'))
                    throw new \Exception('FirePHP is required and must be pointed by $PEAR_PATH config variable');
            }
            try {
                Zend_Loader::loadClass('Zend_View');
                Zend_Loader::loadClass('Zend_Registry');
                Zend_Loader::loadClass('Zend_Db');
                Zend_Loader::loadClass('Zend_Db_Table');
                Zend_Loader::loadClass('Zend_Auth');
                Zend_Loader::loadClass('Zend_Auth_Adapter_DbTable');
                Zend_Loader::loadClass('Zend_Json');
                Zend_Loader::loadClass('Zend_Mail');
                Zend_Loader::loadClass('Zend_Mail_Transport_Smtp');
                Zend_Loader::loadClass('Zend_Cache');
                Zend_Loader::loadClass('Zend_Cache_Core');
                Zend_Loader::loadClass('Zend_Cache_Backend_Apc');
                Zend_Loader::loadClass('Zend_Cache_Backend_File');
            } catch (Exception $e) {
                $message = $e->getMessage();
                if (strpos($message, 'does not exist or class') !== false)
                    throw new \Exception('Zend Module not found: ' . $message);
                else
                    throw $e;
            }

            if (!key_exists('PHPUNIT', $GLOBALS) || !$GLOBALS['PHPUNIT']) {
                $GLOBALS['CACHE'] = new Zend_Cache_Core(array('automatic_serialization' => true));
                if (in_array('apc', get_loaded_extensions()))
                    $GLOBALS['CACHE']->setBackend(new Zend_Cache_Backend_Apc());
                else
                    $GLOBALS['CACHE']->setBackend(new Zend_Cache_Backend_File());
                Zend_Db_Table_Abstract::setDefaultMetadataCache($GLOBALS['CACHE']);
            }
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'content.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'contentcoll.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'formerrors.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'template.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'user.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'usercoll.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'profile.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'log.php');
            require (__DIR__ . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'controler.php');
            $db = Zend_Db::factory($GLOBALS['DB_CONFIG']['adapter'], $GLOBALS['DB_CONFIG']);
            $db->getConnection();
            Zend_Db_Table::setDefaultAdapter($db);
            if (key_exists('DEBUG', $GLOBALS) && $GLOBALS['DEBUG']) {
                $GLOBALS['profiler'] = $db->getProfiler();
                $GLOBALS['profiler']->setEnabled(true);
                $GLOBALS['firephp'] = FirePHP::getInstance(true);
            }

            /**
             * Logs last query
             */
            function lastQuery() {
                if (key_exists('profiler', $GLOBALS) && key_exists('firephp', $GLOBALS)) {
                    $query_profile = $GLOBALS['profiler']->getLastQueryProfile();
                    $params = $query_profile->getQueryParams();
                    $querystr  = $query_profile->getQuery();

                    foreach ($params as $par) {
                        $querystr = preg_replace('/\\?/', "'" . $par . "'", $querystr, 1);
                    }
                    $GLOBALS['firephp']->log($query_profile,$querystr);
                }
            }

        }

        /**
         * Gets the instance
         * @return \AutoLoader
         */
        public static function getInstance() {
            if (self::$instance == null) {
                $c = __CLASS__;
                self::$instance = new $c;
            }

            return self::$instance;
        }

        /**
         * Load required files
         * @param StdClass $class
         */
        public static function loadRequiredFiles(StdClass $class) {
            if (!isset($class->dir))
                throw new Exception('Module base dir is required');
            if (!isset($class->files))
                throw new Exception('Module required files are required');
            $module_name = basename($class->dir);
            if (key_exists($module_name, self::$module_files))
                return;
            self::$module_files[$module_name] = array();
            foreach ($class->files as $file) {
                self::$module_files[$module_name][] = $file;
                require $class->dir . DIRECTORY_SEPARATOR . $file;
            }
        }

    }

}
AutoLoader::getInstance();