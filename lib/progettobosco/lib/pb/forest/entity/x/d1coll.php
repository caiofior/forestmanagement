<?php
/**
 * Manages Entity D1 forest compartment Collection
 * 
 * Manages Entity D1 forest compartment Collection
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
 * Manages Entity D1 forest compartment Collection
 * 
 * Manages Entity D1 forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class D1Coll extends \forest\template\EntityColl {
    /**
     * Reference to the D form
     * @var \forest\entity\x\D
     */
    private $d;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\x\D1());
    }
    /**
     * Set the form D
     * @param \forest\entity\x\D $d
     */
    public function setFormD(\forest\entity\x\D $d) {
        $this->d = $d;
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
        if ($this->d instanceof \forest\entity\x\D &&
                is_array($this->d->getData()) &&
                sizeof($this->d->getData()) == sizeof($this->content->getTable()->info('cols'))) {
            $select->where('sched_d1.proprieta = ?', $this->d->getData('proprieta'))
                   ->where('sched_d1.cod_part = ?', $this->d->getData('cod_part'))
                   ->where('sched_d1.cod_fo = ?', $this->d->getData('cod_fo'))
                   ->where('sched_d1.n_camp = ?', $this->d->getData('n_camp'))
                   ->where('sched_d1.tipo_ril = ?', $this->d->getData('tipo_ril'))
                   ->where('sched_d1.data = ?', $this->d->getData('data'));
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
        if ($this->d instanceof \forest\entity\x\D &&
                is_array($this->d->getData()) &&
                sizeof($this->d->getData()) == sizeof($this->content->getTable()->info('cols')))  {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where('sched_d1.proprieta = ?', $this->d->getData('proprieta'))
                   ->where('sched_d1.cod_part = ?', $this->d->getData('cod_part'))
                   ->where('sched_d1.cod_fo = ?', $this->d->getData('cod_fo'))
                   ->where('sched_d1.n_camp = ?', $this->d->getData('n_camp'))
                   ->where('sched_d1.tipo_ril = ?', $this->d->getData('tipo_ril'))
                   ->where('sched_d1.data = ?', $this->d->getData('data'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else  return 0;
    }
    /**
     * Add new item to the collection
     * @return \forest\entity\x\D1
     */
    public function addItem() {
        $d1 = parent::addItem();
        $d1->setData($this->d->getData('proprieta'),'proprieta');
        $d1->setData($this->d->getData('cod_part'),'cod_part');
        $d1->setData($this->d->getData('cod_fo'),'cod_fo');
        return $d1;
    }

}
