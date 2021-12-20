<?php
/**
 * Manages Arboreal attribute
 * 
 * Manages Arboreal attribute
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
 * Manages Arboreal attribute
 * 
 * Manages Arboreal attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Arboreal  extends \Content {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('diz_arbo');
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('cod_coltu', $this->data)) 
            throw new Exception('Unable to update object without objectid',1302061037);
        $where = $this->table->getAdapter()->quoteInto('cod_coltu = ?', $this->data['cod_coltu']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
        if (key_exists('cod_coltu', $this->data)) {
            $where = $this->table->getAdapter()->quoteInto('cod_coltu = ?', $this->data['cod_coltu']);
            $this->table->delete($where);
        }
    }
}
