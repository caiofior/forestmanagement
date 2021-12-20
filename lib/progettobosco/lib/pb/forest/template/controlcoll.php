<?php 
/**
 * Manages Entity control forest compartment collection
 * 
 * Manages Entity control forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\template;

if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Entity control forest compartment collection
 * 
 * Manages Entity control forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ControlColl extends \ContentColl {
    /**
     * Criteria reference
     * @var array|null
     */
    private $criteria;
    /**
     * Initalizes the table
     * @param string $tablename
     */
    public function __construct($tablename) {
        parent::__construct(new \forest\template\Control($tablename));
    }
    /**
     * Loads all data
     * @param array $criteria
     */
    public function loadAll(array $criteria = null) {
        $this->criteria = $criteria;
        $table =$this->content->getTable();
        if(is_null($table))
            throw new \Exception('Unable to find the attribute in this form',1303041646);
        $dbname = $table->getAdapter()->getConfig();
        $dbname = $dbname['dbname'];
        $items = $GLOBALS['CACHE']->load($dbname.'_'.$this->content->getTable()->info('name'));
        if (is_array($items))
            $this->items = $items;
        else {
            parent::loadAll();
            $GLOBALS['CACHE']->save($this->items,$dbname.'_'.$this->content->getTable()->info('name'));
        }
    }
    /**
     * Return an array of content
     * @return array[\Content]
     */
    public function getFirst() {
        if (is_array($this->criteria)) {
            $raw_items = parent::getItems();
            $selected_item = clone $this->content;
            foreach($raw_items as $item) {
                if ($item->getData(key($this->criteria))==current($this->criteria))
                    $selected_item = $item;
            }
            return $selected_item;
            
        }
        else return parent::getFirst ();
    }
    /**
     * Customizes the select
     * @param \Zend_Db_Select $select
     * @param array $criteria
     * @return \Zend_Db_Select
     */
    public function customSelect(\Zend_Db_Select $select, array $criteria) {
        return $select;
    }
    /**
     * Gets the table associated with a form and field
     * @param string $form form name
     * @param string $field field name
     * @return string table name
     */
    public static function getTable($form, $field) {
        $form = 'schede_a';
        $archivicoll = \forest\template\ArchiveColl::getInstance();
        $archivicoll = $archivicoll->getAllAttributes();
        return $archivicoll[$form][$field]['dizionario'];
    }
    
}