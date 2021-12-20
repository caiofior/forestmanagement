<?php
/**
 * Manages Archivi collection
 * 
 * Manages Archivi collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
*/
namespace forest\template;
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Archivi collection
 * 
 * Manages Archivi collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
final class ArchiveColl {
    /**
     * Reference to static instance
     * @var \forest\template\ArchiveColl
     */
    private static $instance=null;
    /**
     * all attributes collection dividerd by archive and label
     * @var array $all_attributes_data
     */
    private static $all_attributes_data=array();
    /**
     * all attributes collection by id
     * @var array $all_attributes_id
     */
    private static $all_attributes_id=array();
    /**
     * Loads the archive data in cache
     */
    private function __construct() {
        $all_attributes_data = $GLOBALS['CACHE']->load('archivi');
        $all_attributes_id = $GLOBALS['CACHE']->load('archivi_id');
        if (
                is_array($all_attributes_data)&&
                is_array($all_attributes_id)
            ) {
            self::$all_attributes_data=$all_attributes_data;
            self::$all_attributes_id=$all_attributes_id;
        } else {
            $attibutes = new \Zend_Db_Table('archivi');
            $all_attributes_data = $attibutes->fetchAll()->toArray();
            foreach ($all_attributes_data as $attribute_data) {
                self::$all_attributes_id[$attribute_data['id']]=$attribute_data;
                if (!key_exists($attribute_data['archivio'],self::$all_attributes_data))
                    self::$all_attributes_data[$attribute_data['archivio']] =array();
                self::$all_attributes_data[$attribute_data['archivio']][$attribute_data['nomecampo']]=$attribute_data;
            }
            $GLOBALS['CACHE']->save(self::$all_attributes_data,'archivi');
            $GLOBALS['CACHE']->save(self::$all_attributes_id,'archivi_id');
        }
    }
    /**
     * Gets the instance
     * @return \forest\template\ArchiveColl
     */
    public static function getInstance()
    {
      if(self::$instance == null) {   
         $c = __CLASS__;
         self::$instance = new $c;
      }
      
      return self::$instance;
    }
    /**
     * Returns all attributes
     * @return array
     */
    public static function getAllAttributes() {
        return self::$all_attributes_data;
    }
    /**
     * Return and attribute by id
     * @param int $id
     * @return array
     */
    public function getAttributeById($id) {
        if (!key_exists($id, self::$all_attributes_id))
                return;
        return self::$all_attributes_id[$id];
    }
    
}