<?php
/**
 * Manages B1 Cover Composition attribute
 * 
 * Manages B1 Cover Composition attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\covercomposition;

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
 * Manages B1 Cover Composition attribute
 * 
 * Manages B1 Cover Composition attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B1  extends \forest\template\Entity {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('arboree');
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('objectid', $this->data)) 
            throw new Exception('Unable to update object without objectid',1302061037);
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? AND ', $this->data['cod_fo']);
        $where .= $this->table->getAdapter()->quoteInto('cod_coltu = ?', $this->data['cod_coltu']);
        $this->table->update($this->data, $where);
    }
  
}

