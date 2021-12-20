<?php
/**
 * Content object
 * 
 * Content object
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Content object
 * 
 * Content object
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
abstract class Content {
     /**
     * Zend Data table
     * @var Zend_Db_Table 
     */
    protected $table;
    /**
     * Data used for insert and update
     * @var array
     */
    protected $data=array();
    /**
     * Raw data, with cusom culoms
     * @var array
     */
    protected $rawData=array();
    /**
     * Columns available in database
     * @var array
     */
    protected $empty_entity=array();
    /**
     * Primary key
     * @var string
     */
    protected $primary;

    /**
     * Instantiates the table
     * @param string $table
     */
    public function __construct($table=null) {
        if (is_null($table))
            return;
        $this->table = new Zend_Db_Table($table);
        $primary = $this->table->info('primary');
        if (is_array($primary) && sizeof($primary) == 1)
            $this->primary = array_shift ($primary);
        $cols = $this->table->info('cols');
        $cols = array_combine($cols, array_fill ( 0 , sizeof($cols) , null ));
        $this->empty_entity = $cols;
    }
    /**
     * Loads data from its id
     * @param int $id
     */
    public function loadFromId($id) {
        $data = $this->table->find($id)->toArray();
        $this->data = array_shift($data);
    }
     /**
     * Gets the data
     * @param null|sring $field field data of interest
     * @return array
     */
    public function getData($field = null) {
        if (!is_array($this->data))
            return;
        if (is_null($field))
            return $this->data;
        if (key_exists($field, $this->data))
            return $this->data[$field];
    }
     /**
     * Gets the raw data
     * @param null|sring $field field data of interest
     * @return array
     */
    public function getRawData($field = null) {
        if (is_null($field))
            return $this->rawData;
        if (key_exists($field, $this->rawData))
            return $this->rawData[$field];
    }
    /**
     * Sets the data
     * @param variant $data
     * @param string|null $field
     */
    public function setData($data,$field=null){
        if (is_array($data)) {
            $this->data = array_merge($this->data,  array_intersect_key($data,$this->empty_entity));
            $this->rawData = array_merge($this->data, $data);
         }
        else if (!is_null($field) ) {
            if (array_key_exists($field,$this->empty_entity))
                $this->data[$field] = $data;
            $this->rawData[$field] = $data;
        }
    }
    /**
     * Adds a data
     */
    public function insert() {
        $this->data[$this->primary]=$this->table->insert($this->data);
    }
     /**
     * Deletes data
     */
    public function delete() {
        if (key_exists($this->primary, $this->data)) {
            $where = $this->table->getAdapter()->quoteInto($this->primary.' = ?', $this->data[$this->primary]);
            $this->table->delete($where);
        }
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists($this->primary, $this->data)) 
            throw new Exception('Unable to update object without id',1301251051);
        $where = $this->table->getAdapter()->quoteInto($this->primary.' = ?', $this->data[$this->primary]);
        $this->table->update($this->data, $where);
    }
    /**
     * Returns associated db table
     * @return Zend_Db_Table 
     */
    public function getTable() {
        return $this->table;
    }
    /**
     * Is the Content empty
     * @return bool
     */
    public function isEmpty () {
        return sizeof($this->data) ==0;
    }
}
