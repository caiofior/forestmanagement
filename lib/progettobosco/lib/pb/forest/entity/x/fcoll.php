<?php
/**
 * Manages Entity F forest compartment Collection
 * 
 * Manages Entity F forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\x;
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
 * Manages Entity F forest compartment Collection
 * 
 * Manages Entity F forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class FColl extends \forest\template\EntityColl {
    /**
     * Reference to the X form
     * @var \forest\entity\x\X
     */
    private $x;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\F());
    }
    /**
     * Set the form X
     * @param \forest\entity\x\X $x
     */
    public function setFormX(\forest\entity\x\X $x) {
        $this->x = $x;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if (
                $this->x instanceof \forest\entity\x\X &&
                is_array($this->x->getData()) &&
                sizeof($this->x->getData()) == sizeof($this->content->getTable()->info('cols'))
            ) {
            $select->where('schede_f.proprieta = ?', $this->x->getData('proprieta'))
                   ->where('schede_f.cod_part = ?', $this->x->getData('cod_part'))
                   ->where('schede_f.cod_fo = ?', $this->x->getData('cod_fo'));
        }
        else {
            $select->where('FALSE');
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if (
                $this->x instanceof \forest\entity\x\X &&
                is_array($this->x->getData()) &&
                sizeof($this->x->getData()) == sizeof($this->content->getTable()->info('cols'))
            )  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('schede_f.proprieta = ?', $this->x->getData('proprieta'))
                   ->where('schede_f.cod_part = ?', $this->x->getData('cod_part'))
                   ->where('schede_f.cod_fo = ?', $this->x->getData('cod_fo'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else return 0;
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\x\D
     */
    public function addItem() {
        $f = parent::addItem();
        $f->setData($this->x->getData('proprieta'),'proprieta');
        $f->setData($this->x->getData('cod_part'),'cod_part');
        $f->setData($this->x->getData('cod_fo'),'cod_fo');
        return $f;
    }

}
