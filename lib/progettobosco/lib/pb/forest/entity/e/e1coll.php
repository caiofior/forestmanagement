<?php
/**
 * Manages Entity E1 forest compartment Collection
 * 
 * Manages Entity E1 forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\e;

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
 * Manages Entity E1 forest compartment Collection
 * 
 * Manages Entity E1 forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class E1Coll extends \forest\template\EntityColl {
    /**
     * E object
     * @var \forest\entity\e\E
     */
    private $e;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\e\E1());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)->from($this->content->getTable()->info('name'),array(
            '*',
            'cod_inter_descr'=>new \Zend_Db_Expr(
                '( SELECT descriz FROM int_via WHERE int_via.codice=sched_e1.cod_inter) '
             )
        ));
        if ($this->e instanceof \forest\entity\e\E && $this->e->getData('poprieta') != '') {
                 $select->where('sched_e1.proprieta = ?', $this->e->getData('poprieta'));
                 $select->where('sched_e1.strada = ?', $this->e->getData('strada'));
        }
        return $select;
    }
    /**
     * Sets e compartment forest
     * @param \forest\entity\e\E $e
     */
    public function setFormE(\forest\entity\e\E $e) {
        $this->e = $e;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->e instanceof \forest\entity\e\E || is_array($criteria)) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
             if ($this->e instanceof \forest\Forest && $this->e->getData('poprieta') != '') {
                 $select->where('sched_e1.proprieta = ?', $this->e->getData('proprieta'));
                 $select->where('sched_e1.strada = ?', $this->e->getData('strada'));
             }
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
     /**
     * Adds new item to the form
     * @return \forest\entity\E1
     */
    public function addItem() {
        $e1 = parent::addItem();
        $e1->setData($this->e->getData('proprieta'),'proprieta');
        $e1->setData($this->e->getData('objectid'),'strada');
        return $e1;
    }


}
