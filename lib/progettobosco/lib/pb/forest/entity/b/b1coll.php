<?php
/**
 * Manages Entity B1 forest compartment collection
 * 
 * Manages Entity B1 forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\b;

if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Entity B1 forest compartment collection
 * 
 * Manages Entity B1 forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B1Coll extends \forest\template\EntityColl {
     /**
     * Reference to form B
     * @var \forest\entity\b\B
     */
    private $b;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\b\B1());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->b instanceof \forest\entity\b\B) {
            $select->where('sched_b1.proprieta = ?', $this->b->getData('proprieta'))
                   ->where('sched_b1.cod_part = ?', $this->b->getData('cod_part'))
                   ->where('sched_b1.cod_fo = ?', $this->b->getData('cod_fo'));
        }
        return $select;
    }
    /**
     * Set the form a
     * @param \forest\entity\b\B $b
     */
    public function setFormB(\forest\entity\b\B $b) {
        $this->b = $b;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(?array $criteria = null) {
        if ($this->b instanceof \forest\entity\b\B) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('sched_b1.proprieta = ?', $this->b->getData('proprieta'))
                   ->where('sched_b1.cod_part = ?', $this->b->getData('cod_part'))
                   ->where('sched_b1.cod_fo = ?', $this->b->getData('cod_fo'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else
            return parent::countAll();

    }
    /**
     * Add new item to the collection
     * @return \forest\entity\b\B1
     */
    public function addItem() {
        $b1 = parent::addItem();
        $b1->setData($this->b->getData('proprieta'),'proprieta');
        $b1->setData($this->b->getData('cod_part'),'cod_part');
        $b1->setData($this->b->getData('cod_fo'),'cod_fo');
        return $b1;
    }

}
