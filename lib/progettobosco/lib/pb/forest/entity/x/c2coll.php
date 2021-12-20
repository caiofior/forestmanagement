<?php
/**
 * Manages Entity C2 forest compartment Collection
 * 
 * Manages Entity C2 forest compartment Collection
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
 * Manages Entity C2 forest compartment Collection
 * 
 * Manages Entity C2 forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class C2Coll extends \forest\template\EntityColl {
    /**
     * Reference to the C form
     * @var \forest\entity\x\C
     */
    private $c;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\C2());
    }
    /**
     * Set the form C
     * @param \forest\entity\x\C $c
     */
    public function setFormC(\forest\entity\x\C $c) {
        $this->c = $c;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)->from(
                $this->content->getTable()->info('name'),
                array(
                    '*',
                    'specie_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_arbo.nome_itali || \' | \' || diz_arbo.nome_scien FROM diz_arbo WHERE diz_arbo.cod_coltu='.$this->content->getTable()->info('name').'.specie) '
                    )
                ));
        if ($this->c instanceof \forest\entity\x\C) {
            $select->where('sched_c2.proprieta = ?', $this->c->getData('proprieta'))
                   ->where('sched_c2.cod_part = ?', $this->c->getData('cod_part'))
                   ->where('sched_c2.cod_fo = ?', $this->c->getData('cod_fo'))
                   ->where('sched_c2.tipo_ril = ?', $this->c->getData('tipo_ril'))
                   ->where('sched_c2.data = ?', $this->c->getData('data'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->c instanceof \forest\entity\x\C)  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('sched_c2.proprieta = ?', $this->c->getData('proprieta'))
                   ->where('sched_c2.cod_part = ?', $this->c->getData('cod_part'))
                   ->where('sched_c2.cod_fo = ?', $this->c->getData('cod_fo'))
                   ->where('sched_c2.tipo_ril = ?', $this->c->getData('tipo_ril'))
                   ->where('sched_c2.data = ?', $this->c->getData('data'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else
            return parent::countAll();
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\x\C1
     */
    public function addItem() {
        $c1 = parent::addItem();
        $c1->setData($this->c->getData('proprieta'),'proprieta');
        $c1->setData($this->c->getData('cod_part'),'cod_part');
        $c1->setData($this->c->getData('cod_fo'),'cod_fo');
        return $c1;
    }

}
