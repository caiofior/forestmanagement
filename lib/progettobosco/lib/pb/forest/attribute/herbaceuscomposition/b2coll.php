<?php
/**
 * Manages B2 Herbaceus Composition collection
 * 
 * Manages B2 Herbaceus Composition collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\herbaceuscomposition;

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
 * Manages B2 Herbaceus Composition collection
 * 
 * Manages B2 Herbaceus Composition collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B2Coll  extends \ContentColl  {
    /**
     * Forest Reference
     * @var \forest\entity\b\B2
     */
    protected $form_b2=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\attribute\herbaceuscomposition\B2());
    }
    /**
     * Sets the form reference
     * @param \forest\entity\b\B2 $form Entity b2
     */
    public function setForm(\forest\entity\b\B2 $form) {

        $this->form_b2 = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('erbacee2',array(
            '*',
            'cod_colt_descriz'=>new \Zend_Db_Expr(
                '( SELECT diz_erba.nome FROM diz_erba WHERE diz_erba.cod_coltu=erbacee2.cod_coltu) '
             )
        ));
        if ($this->form_b2 instanceof \forest\entity\b\B2) {
            $select->where(' cod_part = ? ',$this->form_b2->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b2->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b2->getData('cod_fo'));
            
        }
        $select->order('cod_coltu');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_b2 instanceof \forest\entity\b\B2) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_b2->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_b2->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_b2->getData('cod_fo'))
            ;
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
    /**
     * Adds new forest composition 
     * @return B1
     */
    public function addItem() {
        $forestcovercomposition = parent::addItem();
        $forestcovercomposition->setData($this->form_b2->getData('cod_fo'),'cod_fo');
        $forestcovercomposition->setData($this->form_b2->getData('cod_part'),'cod_part');
        $forestcovercomposition->setData($this->form_b2->getData('proprieta'),'proprieta');
        return $forestcovercomposition;
    }
 }
