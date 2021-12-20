<?php
/**
 * Manages Entity F2 forest compartment Collection
 * 
 * Manages Entity F2 forest compartment Collection
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
 * Manages Entity F2 forest compartment Collection
 * 
 * Manages Entity F2 forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class F2Coll extends \forest\template\EntityColl {
    /**
     * Reference to the F form
     * @var \forest\entity\x\F
     */
    private $f;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\F2());
    }
    /**
     * Set the form F
     * @param \forest\entity\x\F $f
     */
    public function setFormF(\forest\entity\x\F $f) {
        $this->f = $f;
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
        if ($this->f instanceof \forest\entity\x\D) {
            $select->where('sched_f2.proprieta = ?', $this->f->getData('proprieta'))
                   ->where('sched_f2.cod_part = ?', $this->f->getData('cod_part'))
                   ->where('sched_f2.cod_fo = ?', $this->f->getData('cod_fo'))
                   ->where('sched_f2.n_camp = ?', $this->f->getData('n_camp'))
                   ->where('sched_f2.tipo_ril = ?', $this->f->getData('tipo_ril'))
                   ->where('sched_f2.data = ?', $this->f->getData('data'));
        }
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->f instanceof \forest\entity\x\D)  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('sched_f2.proprieta = ?', $this->f->getData('proprieta'))
                   ->where('sched_f2.cod_part = ?', $this->f->getData('cod_part'))
                   ->where('sched_f2.cod_fo = ?', $this->f->getData('cod_fo'))
                   ->where('sched_f2.n_camp = ?', $this->f->getData('n_camp'))
                   ->where('sched_f2.tipo_ril = ?', $this->f->getData('tipo_ril'))
                   ->where('sched_f2.data = ?', $this->f->getData('data'));
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
        $d = parent::addItem();
        $d->setData($this->f->getData('proprieta'),'proprieta');
        $d->setData($this->f->getData('cod_part'),'cod_part');
        $d->setData($this->f->getData('cod_fo'),'cod_fo');
        return $d;
    }

}
