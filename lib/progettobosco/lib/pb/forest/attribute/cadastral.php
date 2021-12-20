<?php
/**
 * Manages Cadastral attribute
 * 
 * Manages Cadastral attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Cadastral attribute
 * 
 * Manages Cadastral attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Cadastral  extends \Content implements \forest\template\Attribute {
    /**
     * Entity a has to be updated
     * @var bool
     */
    private $update_forma=false;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('catasto');
    }
    /**
     * Rediclared set data
     * @param type $data
     * @param type $field
     */
    public function setData($data, $field = null) {
        if (!key_exists($field, $this->empty_entity))
            $this->update_forma = true;
        parent::setData($data, $field);
    }
    /**
     * Updates data
     */
    public function update() {
        if (!key_exists('objectid', $this->data)) 
            throw new Exception('Unable to update object without objectid',1302061037);
        $where = $this->table->getAdapter()->quoteInto('objectid = ?', $this->data['objectid']);
        $this->table->update($this->data, $where);
        if ($this->update_forma) {
            $form_a = $this->getFormA();
            $form_a->setData($this->rawData);
            $form_a->update();
        }
    }
    /**
     * Returns the associated Form A
     * @return \forest\entity\A
     */
    private function getFormA() {
        $form_a = new \forest\entity\A();
        $form_a->loadFromCodePart($this->data['proprieta'], $this->data['cod_part']);
        return $form_a;
    }
}
