<?php
/**
 * Manages Note A collection
 * 
 * Manages Note A collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\note;

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
 * Manages Note A collection
 * 
 * Manages Note A collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class AColl  extends \ContentColl  {
    /**
     * Entity A Reference
     * @var \forest\entity\A
     */
    protected $form_a=null;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\attribute\note\A());
    }
    /**
     * Sets the form reference
     * @param \forest\entity\A $form
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
        ->from($this->content->getTable()->info('name'),array(
            '*',
            'nota_descr'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'intesta'
                            )->where('leg_note.archivio = \'SCHEDE_A\'')->where('leg_note.nomecampo = note_a.cod_nota').
                    ')')
            ,
            'nota_objectid'=>new \Zend_Db_Expr(
                    '('.
                    $select->getAdapter()->select()->from('leg_note',
                            'objectid'
                            )->where('leg_note.archivio = \'SCHEDE_A\'')->where('leg_note.nomecampo = note_a.cod_nota').
                    ')')
            )   
            );
        if ($this->form_a instanceof \forest\entity\A) {
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_a->getData('cod_fo'))
            ;
        }
        if (is_array ($criteria) && key_exists('field', $criteria) && $criteria['field']!= '')
            $select->where ('cod_nota = ?', $criteria['field']);
        $select->order('cod_nota');
        return $select;
    }
     /**
     * Returns all contents without any filter
     * @param array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->form_a instanceof \forest\entity\A) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
            $select->where(' cod_part = ? ',$this->form_a->getData('cod_part'))
            ->where(' proprieta = ? ',$this->form_a->getData('proprieta'))
            ->where(' cod_fo = ? ',$this->form_a->getData('cod_fo'))
            ;
            if (is_array ($criteria) && key_exists('field', $criteria) && $criteria['field']!= '')
                $select->where ('cod_nota = ?', $criteria['field']);
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
    /**
     * Adds new note to form a
     * @return A
     */
    public function addItem() {
        $note = parent::addItem();
        $note->setData($this->form_a->getData('cod_part'),'cod_part');
        $note->setData($this->form_a->getData('proprieta'),'proprieta');
        $note->setData($this->form_a->getData('cod_fo'),'cod_fo');
        return $note;
    }
}
