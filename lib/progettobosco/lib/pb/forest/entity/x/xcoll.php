<?php
/**
 * Manages Entity X forest compartment Collection
 * 
 * Manages Entity X forest compartment Collection
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
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Entity X forest compartment Collection
 * 
 * Manages Entity X forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class XColl extends \forest\template\EntityColl {
    /**
     * Reference to the B1 form
     * @var \forest\entity\b\B1
     */
    private $b1;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\X());
    }
    /**
     * Set the form a
     * @param \forest\entity\b\B1 $b1
     */
    public function setFormB1(\forest\entity\b\B1 $b1) {
        $this->b1 = $b1;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        $select->from($this->content->getTable()->info('name'),array(
            '*',
            'ril_descr'=>new \Zend_Db_Expr('('.
                    $select->getAdapter()->select()->from('diz_tiporil',
                            new \Zend_Db_Expr('descrizion')
                            )->where('diz_tiporil.codice = '.$this->content->getTable()->info('name').'.tipo_ril').
                    ')')
            ));
        if ($this->b1 instanceof \forest\entity\b\B1) {
            $select->where('schede_x.proprieta = ?', $this->b1->getData('proprieta'))
                   ->where('schede_x.cod_part = ?', $this->b1->getData('cod_part'))
                   ->where('schede_x.cod_fo = ?', $this->b1->getData('cod_fo'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->b1 instanceof \forest\entity\b\B1)  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('schede_x.proprieta = ?', $this->b1->getData('proprieta'))
                   ->where('schede_x.cod_part = ?', $this->b1->getData('cod_part'))
                   ->where('schede_x.cod_fo = ?', $this->b1->getData('cod_fo'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else
            return parent::countAll();
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\x\X
     */
    public function addItem() {
        $x = parent::addItem();
        $x->setData($this->b1->getData('proprieta'),'proprieta');
        $x->setData($this->b1->getData('cod_part'),'cod_part');
        $x->setData($this->b1->getData('cod_fo'),'cod_fo');
        $x->setData(0,'u');
        return $x;
    }

}
