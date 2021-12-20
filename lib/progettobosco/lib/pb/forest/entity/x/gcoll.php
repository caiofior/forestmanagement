<?php
/**
 * Manages Entity G forest compartment Collection
 * 
 * Manages Entity G forest compartment Collection
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
 * Manages Entity G forest compartment Collection
 * 
 * Manages Entity G forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class GColl extends \forest\template\EntityColl {
    /**
     * Reference to the G1 form
     * @var \forest\entity\x\G1
     */
    private $g1;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\G1());
    }
    /**
     * Set the form G1
     * @param \forest\entity\x\G1 $g1
     */
    public function setFormG1(\forest\entity\x\G1 $g1) {
        $this->g1 = $g1;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->g1 instanceof \forest\entity\x\G1 &&
                is_array($this->g1->getData()) &&
                sizeof($this->g1->getData()) == sizeof($this->content->getTable()->info('cols'))) {
            $select->where('schede_g.proprieta = ?', $this->g1->getData('proprieta'))
                   ->where('schede_g.cod_part = ?', $this->g1->getData('cod_part'))
                   ->where('schede_g.cod_fo = ?', $this->g1->getData('cod_fo'))
                   ->where('schede_g.tipo_ril = ?', $this->g1->getData('tipo_ril'))
                   ->where('schede_g.data = ?', $this->g1->getData('data'));
        } else {
            $select->where('FALSE');
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->g1 instanceof \forest\entity\x\D &&
                is_array($this->g1->getData()) &&
                sizeof($this->g1->getData()) == sizeof($this->content->getTable()->info('cols')))  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('schede_g.proprieta = ?', $this->g1->getData('proprieta'))
                   ->where('schede_g.cod_part = ?', $this->g1->getData('cod_part'))
                   ->where('schede_g.cod_fo = ?', $this->g1->getData('cod_fo'))
                   ->where('schede_g.tipo_ril = ?', $this->g1->getData('tipo_ril'))
                   ->where('schede_g.data = ?', $this->g1->getData('data'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else  return 0;
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\x\G1
     */
    public function addItem() {
        $g1 = parent::addItem();
        $g1->setData($this->g1->getData('proprieta'),'proprieta');
        $g1->setData($this->g1->getData('cod_part'),'cod_part');
        $g1->setData($this->g1->getData('cod_fo'),'cod_fo');
        $g1->setData($this->g1->getData('tipo_ril'),'tipo_ril');
        $g1->setData($this->g1->getData('data'),'data');
        return $g1;
    }

}
