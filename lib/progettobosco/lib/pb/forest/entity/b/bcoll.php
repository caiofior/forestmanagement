<?php
/**
 * Manages Entity B forest compartment Collection
 * 
 * Manages Entity B forest compartment Collection
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
 * Manages Entity B forest compartment Collection
 * 
 * Manages Entity B forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class BColl extends \forest\template\EntityColl {
    /**
     * Reference to the A form
     * @var \forest\entity\A
     */
    private $a;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\b\B());
    }
    /**
     * Set the form a
     * @param \forest\entity\A $a
     */
    public function setFormA(\forest\entity\A $a) {
        $this->a = $a;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->a instanceof \forest\entity\A) {
            $select->where('schede_b.proprieta = ?', $this->a->getData('proprieta'))
                   ->where('schede_b.cod_part = ?', $this->a->getData('cod_part'))
                   ->where('schede_b.cod_fo = ?', $this->a->getData('cod_fo'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->a instanceof \forest\entity\A)  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('schede_b.proprieta = ?', $this->a->getData('proprieta'))
                   ->where('schede_b.cod_part = ?', $this->a->getData('cod_part'))
                   ->where('schede_b.cod_fo = ?', $this->a->getData('cod_fo'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else
            return parent::countAll();
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\b\B
     */
    public function addItem() {
        $b = parent::addItem();
        $b->setData($this->a->getData('proprieta'),'proprieta');
        $b->setData($this->a->getData('cod_part'),'cod_part');
        $b->setData($this->a->getData('cod_fo'),'cod_fo');
        $b->setData(0,'u');
        return $b;
    }

}
