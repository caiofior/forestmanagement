<?php
/**
 * Manages Entity X forest compartment
 * 
 * Manages Entity X forest compartment
 * 
 * @link https://it.wikipedia.org/wiki/Rilevamento_dendrometrico
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\x;
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
 * Manages Entity X forest compartment
 * 
 * Manages Entity X forest compartment
 * 
 * @link https://it.wikipedia.org/wiki/Rilevamento_dendrometrico
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class X extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_x');
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
     */
    public function loadFromCodePart($proprieta,$cod_part) {
        $where = $this->table->getAdapter()->quoteInto('proprieta = ?', $proprieta).' AND ';
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ?', $cod_part);
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
            if ($value=='') $this->data[$key]=null;
        $b = $this->getFormB();
        $b->setData($this->rawData);
        $b->update();
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
     * Return the associated A form
     * @return \forest\entity\A
     */
    public function getFormA() {
        $a = new \forest\entity\A();
        if (
                key_exists('proprieta',$this->data) &&
                key_exists('cod_part',$this->data) &&
                key_exists('cod_fo',$this->data)
            )
        $a->loadFromCodePart($this->data['proprieta'],$this->data['cod_part'],$this->data['cod_fo']);
        return $a;
    }
    /**
     * Returns the associated D collection
     * @return \forest\entity\x\DColl
     */
    public function getDColl() {
        $dcoll = new \forest\entity\x\DColl();
        $dcoll->setFormX($this);
        return $dcoll;
    }
    /**
     * Returns the associated C collection
     * @return \forest\entity\x\CColl
     */
    public function getCColl() {
        $ccoll = new \forest\entity\x\CColl();
        $ccoll->setFormX($this);
        return $ccoll;
    }    
     /**
     * Returns the associated F collection
     * @return \forest\entity\x\FColl
     */
    public function getFColl() {
        $fcoll = new \forest\entity\x\FColl();
        $fcoll->setFormX($this);
        return $fcoll;
    }
    /**
     * Returns the associated G1 collection
     * @return \forest\entity\x\G1Coll
     */
    public function getG1Coll() {
        $g1coll = new \forest\entity\x\G1Coll();
        $g1coll->setFormX($this);
        return $g1coll;
    }
} 
