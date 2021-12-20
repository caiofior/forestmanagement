<?php
/**
 * Manages Cadastral collection
 * 
 * Manages Cadastral collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
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
 * Manages Cadastral collection
 * 
 * Manages Cadastral collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class CadastralColl  extends \ContentColl implements \forest\template\AttributeColl {
     /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     * Entity a Reference
     * @var \forest\entity\A
     */
    protected $form_a=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Cadastral());
    }
     /**
     * Sets the forest reference
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Sets the form reference
     * @param \forest\entity\A $form Entity a
     */
    public function setForm(\forest\entity\A $form) {

        $this->form_a = $form;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from($this->content->getTable()->info('name'));
        if ($this->forest instanceof \forest\Forest) {
            $forma = new \forest\entity\A();
            $select = $forma->getTable()->select()->from('schede_a',array(
                '*',
                'schede_a_sup_tot'=>'sup_tot',
                'calcolo'=>new \Zend_Db_Expr('
                    CASE WHEN i1 <> 0 THEN  i1
                    ELSE
                        CASE WHEN i2 <> 0 THEN  i2/100
                        ELSE
                         0
                        END
                    END +
                    CASE WHEN i21 <> 0 THEN  i21
                    ELSE
                        CASE WHEN i22 <> 0 THEN  i22/100
                        ELSE
                         0
                        END
                    END
                    ')
                
            ))->setIntegrityCheck(false)
            ->joinRight(
                    'catasto',
                    'catasto.proprieta=schede_a.proprieta AND catasto.cod_part=schede_a.cod_part',
                    array(
                        '*',
                        'catasto_sup_tot'=>'sup_tot',
                        'non_boscata'=>new \Zend_Db_Expr('catasto.sup_tot - sup_bosc')
                        )
                    )
            ->where(' schede_a.proprieta = ? ',$this->forest->getData('codice'));
        }else if ($this->form_a instanceof \forest\entity\A) {
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_a->getData('cod_fo'))
            ;
            
        }
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where(' particella LIKE ? OR foglio LIKE ?', '%'.$criteria['search'].'%');   
        }
        $select->order('foglio')->order('particella');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->forest instanceof \forest\Forest) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' proprieta = ? ',$this->forest->getData('codice'));
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        } else if ($this->form_a instanceof \forest\entity\A) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_a->getData('cod_fo'))
            ;
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
    /**
     * Adds new cadastra to form a
     * @return Cadastral
     */
    public function addItem() {
        $cadastral = parent::addItem();
        $cadastral->setData($this->form_a->getData('cod_part'),'cod_part');
        $cadastral->setData($this->form_a->getData('proprieta'),'proprieta');
        $cadastral->setData(0,'foglio');
        $cadastral->setData(0,'particella');
        return $cadastral;
    }
    /**
     * Returns a cummary of cadastral data
     * @return array
     */
    public function getSummary() {
         $select = $this->content->getTable()->select()
                 ->from($this->content->getTable()->info('name'),array(
                     'sum_sup_tot_cat'=>'SUM(sup_tot_cat)',
                     'sum_sup_tot'=>'SUM(sup_tot)',
                     'sum_sup_bosc'=>'SUM(sup_bosc)'
                     ));
         if ($this->form_a instanceof \forest\entity\A) {
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'));
        }
        return $this->content->getTable()->getAdapter()->fetchRow($select);
        
    }
}
