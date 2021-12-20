<?php
/**
 * Manages Description
 * 
 * Manages Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\mediator;


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
 * Manages Description
 * 
 * Manages Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
abstract class Description  {
        /**
     * Gets the associated label of a control
     * @param string $form form name
     * @param string $field field name
     * @param mixed $codice code value
     * @return string associated label
     */
    protected function getValue ($form,$field,$codice) {
        $table = \forest\template\ControlColl::getTable($form,$field);
        $control = new \forest\template\ControlColl($table);
        try {
        $control->loadAll(array('codice'=>$codice));
        } catch (\Exception $e) {
            if ($e->getCode() != 1303041646) throw $e;
        }
        $control = $control->getFirst();
        return $control->getData('descriz');
    }
    /**
     * Adds a new issue
     * @param string $form
     * @param string $field
     * @param string $text
     */
    protected function addIssue ($form, $field, $text) {
        $this->issues[$form][$field]=$text;
    }
    /**
     * get the note associated with a field
     * @param string $form
     * @param string $field
     * @return string
     */
    protected function getNote($form, $field) {
         $note = new \forest\attribute\note\AColl();
         $note->setForm($this->a);
         $note->loadAll(array('field'=>$field));
         $note = $note->getFirst();      
         return $note->getData('nota');
    }
}