<?php
/**
 * Manages Forest Mass Esteem attribute
 * 
 * Manages Forest Mass Esteem attribute
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
 * Manages Forest Mass Esteem attribute
 * 
 * Manages Forest Mass Esteem attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ForestMassEsteem  extends \forest\template\Entity {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('stime_b1');
    }
     /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        if (is_string($id))
            $key = explode('-',$id);
        $key = array_values(array_filter($key));
        foreach($key as $kid=>$val)
             $key[$kid]=str_replace('_', ' ', $val);
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $key[0]);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $key[1]);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? AND ', $key[2]);
        $where .= $this->table->getAdapter()->quoteInto('cod_coltu = ?', $key[3]);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the cod part',1302081202);
        $this->rawData['objectid']=$id;
        $this->data = $data->toArray();
    }
     /**
     * Updates data
     */
    public function update() {
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? AND ', $this->data['cod_fo']);
        $where .= $this->table->getAdapter()->quoteInto('cod_coltu = ?', $this->data['cod_coltu']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
            $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
            $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
            $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? AND ', $this->data['cod_fo']);
            $where .= $this->table->getAdapter()->quoteInto('cod_coltu = ?', $this->data['cod_coltu']);
            $this->table->delete($where);
    }
}

