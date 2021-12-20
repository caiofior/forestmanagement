<?php
/**
 * Manages controler
 * 
 * Manages controler
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages controler
 * 
 * Manages controler
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
final class Controler {
        /**
         * Called file is null
         * @var string
         */
        private static $file=null;
        /**
         * Controller dir
         * @var string
         */
        private static $control_dir = null;
        /**
         * List of required files
         * @var array
         */
        private static $required_files=array();
        /**
         * xhr file to include
         * @var array
         */
        private static $xhr_files = array();
        /**
         * Reference to static instance
         * @var \AutoLoader
         */
        private static $instance = null;
        /**
         * Instantiares the main loading class
         */
        private function __construct() {
            if(is_file(self::$control_dir.DIRECTORY_SEPARATOR.self::$file))
                self::$required_files[] = self::$control_dir.DIRECTORY_SEPARATOR.self::$file;
            if (!isset($_REQUEST)) return;
            $path = self::$control_dir.DIRECTORY_SEPARATOR.str_replace('.php', '', self::$file);
            if(
                    key_exists('task',$_REQUEST) &&
                    is_file($path.DIRECTORY_SEPARATOR.$_REQUEST['task'].'.php')
                    ) {
                self::$required_files[] = $path.DIRECTORY_SEPARATOR.$_REQUEST['task'].'.php';
                $path .= DIRECTORY_SEPARATOR.$_REQUEST['task'];
            }
            if(
                    key_exists('action',$_REQUEST) &&
                    is_file($path.DIRECTORY_SEPARATOR.$_REQUEST['action'].'.php')
                    ) {
                self::$required_files[] = $path.DIRECTORY_SEPARATOR.$_REQUEST['action'].'.php';
                $path .= DIRECTORY_SEPARATOR.$_REQUEST['action'];
            }
            if (key_exists('xhr', $_REQUEST) && is_array($_REQUEST['xhr']))
                self::$xhr_files = $_REQUEST['xhr'];
        }
        /**
         * Return reqiored file for the control cascade
         * @return array
         */
        public static function getRequiredControls () {
            $required_files = self::$required_files;
            self::$required_files = array();
            return $required_files;
        }
        /**
         * Gets the instance
         * @param string $file
         * @param string $control_dir
         * @return Controler
         * @throws \Exception
         */
        public static function getInstance($file=null,$control_dir = null) {
            if (self::$instance == null) {
                if (is_null($file))
                    throw new \Exception('Called file is null');
                if (is_null($control_dir))
                    throw new \Exception('Control dir is required');
                else if (!is_dir($control_dir))
                    throw new \Exception('Control dir is not available');
                self::$file = basename($file);
                self::$control_dir = $control_dir;
                $c = __CLASS__;
                self::$instance = new $c;
            }

            return self::$instance;
        }
        /**
         * Returns the xhr files
         * @return array
         */
        public function getXhrFiles() {
            return self::$xhr_files;
        }
}