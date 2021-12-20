<?php
/**
 * Manages Entity B forest compartment
 * 
 * Manages Entity B forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\b;
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
 * Manages Entity B forest compartment
 * 
 * Manages Entity B forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_b');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        $this->calculatedVariables();
    }
    /**
     * Loads form a data form foreat and parcel code
     * @param string $proprieta Proprietà code
     * @param string $cod_part Forest compartment code
     * @param string $cod_fo Forest compartment code
     */
    public function loadFromCodePart($proprieta,$cod_part,$cod_fo) {
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $proprieta);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $cod_part);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ?', $cod_fo);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the cod part',1302081202);
        $this->data = $data->toArray();
        $this->calculatedVariables();
    }
    /**
     * Sets the calculated variables
     */
    private function calculatedVariables () {
       
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('proprieta', $this->data) ||
            !key_exists('cod_part', $this->data) ||
            !key_exists('cod_fo', $this->data)
            ) 
            throw new \Exception('Unable to update object without proprieta,cod_part and cod_fo',1301251130);
        foreach($this->data as $key=>$value)
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
        $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? ', $this->data['cod_fo']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
            $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
            $where .= $this->table->getAdapter()->quoteInto('cod_part = ? AND ', $this->data['cod_part']);
            $where .= $this->table->getAdapter()->quoteInto('cod_fo = ? ', $this->data['cod_fo']);
            $this->table->delete($where);
    }
    /**
     * Return the associated B1 Collection
     * @return \forest\entity\b\B1Coll
     */
    public function getB1Coll () {
        $b1coll = new \forest\entity\b\B1Coll();
        $b1coll->setFormB($this);
        $b1coll->loadAll();
        return $b1coll;
    }
    /**
     * Gets associated Forest Type
     * @return \forest\attribute\ForestType
     */
    public function getForestType () {
        $foresttype = new \forest\attribute\ForestType();
        if (key_exists('t', $this->data))
            $foresttype->loadFromCode($this->data['t']);
        return $foresttype;
    }
     /**
     * Return the associated B2 Collection
     * @return \forest\entity\b\B3Coll
     */
    public function getB2Coll () {
        $b2coll = new \forest\entity\b\B2Coll();
        $b2coll->setFormB($this);
        $b2coll->loadAll();
        return $b2coll;
    }
     /**
     * Return the associated B3 Collection
     * @return \forest\entity\b\B3Coll
     */
    public function getB3Coll () {
        $b3coll = new \forest\entity\b\B3Coll();
        $b3coll->setFormB($this);
        $b3coll->loadAll();
        return $b3coll;
    }
     /**
     * Return the associated B4 Collection
     * @return \forest\entity\b\B4Coll
     */
    public function getB4Coll () {
        $b4coll = new \forest\entity\b\B4Coll();
        $b4coll->setFormB($this);
        $b4coll->loadAll();
        return $b4coll;
    }
     /**
     * Return the associated N Collection
     * @return \forest\entity\NColl
     */
    public function getNColl () {
        $ncoll = new \forest\entity\NColl();
        $ncoll->setFormB($this);
        $ncoll->loadAll();
        return $ncoll;
    }
} 
