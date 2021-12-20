<?php
/**
 * Manages Entity N forest compartment Collection
 * 
 * Manages Entity N forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity;
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
 * Manages Entity N forest compartment Collection
 * 
 * Manages Entity N forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class NColl extends \forest\template\EntityColl {
    /**
     * Reference to the B form
     * @var \forest\entity\b\B
     */
    private $b;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\N());
    }
    /**
     * Set the form b
     * @param \forest\entity\b\B $b
     */
    public function setFormB(b\B $b) {
        $this->b = $b;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->b instanceof b\B) {
            $select->where('schede_n.proprieta = ?', $this->b->getData('proprieta'))
                   ->where('schede_n.cod_part = ?', $this->b->getData('cod_part'))
                   ->where('schede_n.cod_fo = ?', $this->b->getData('cod_fo'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->b instanceof b\B)  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('schede_n.proprieta = ?', $this->b->getData('proprieta'))
                   ->where('schede_n.cod_part = ?', $this->b->getData('cod_part'))
                   ->where('schede_n.cod_fo = ?', $this->b->getData('cod_fo'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else
            return parent::countAll();
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\N
     */
    public function addItem() {
        $n = parent::addItem();
        $n->setData($this->b->getData('proprieta'),'proprieta');
        $n->setData($this->b->getData('cod_part'),'cod_part');
        $n->setData($this->b->getData('cod_fo'),'cod_fo');
        $n->setData(0,'u');
        return $n;
    }

}
