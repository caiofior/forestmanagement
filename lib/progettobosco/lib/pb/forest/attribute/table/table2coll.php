<?php
/**
 * Manages Table2 collection
 * 
 * Manages Table2 collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\table;
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
 * Manages Table2 collection collection
 * 
 * Manages Table2 collection collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Table2Coll  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\attribute\Table
     */
    protected $table=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Table2());
    }
    /**
     * Sets the form reference
     * @param \forest\attribute\Table $table Table
     */
    public function setTable(\forest\attribute\Table $table) {

        $this->table = $table;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        if ($this->table instanceof \forest\attribute\Table) {
            $select->where('codice = ?',$this->table->getData('codice'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
            if ($this->table instanceof \forest\attribute\Table) {
                $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
                $select = $this->customSelect($select,array());
                return intval($this->content->getTable()->getAdapter()->fetchOne($select));
            }
            return parent::countAll();
    }
    /**
     * Adds new forest composition 
     * @return \forest\attribute\Table2
     */
    public function addItem() {
        $table2 = parent::addItem();
        $table2->setData($this->table->getData('codice'),'codice');
        return $table2;
    }
 }
