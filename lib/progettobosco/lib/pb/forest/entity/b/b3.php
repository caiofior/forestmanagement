<?php
/**
 * Manages Entity B3 forest compartment
 * 
 * Manages Entity B3 forest compartment
 * 
 * @link https://it.wikipedia.org/wiki/Formazione_erbacea
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
 * Manages Entity B3 forest compartment
 * 
 * Manages Entity B3 forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class B3 extends \forest\template\Entity implements \forest\entity\template\FormBX {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('sched_b3');
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
     * Return the associated note collection
     * @return \forest\attribute\note\B3Coll
     */
    public function getNotes () {
        $notes = new \forest\attribute\note\B3Coll();
        $notes->setForm($this);
        return $notes;
    }
    /**
     * Return the associated B fomr
     * @return \forest\entity\b\B
     */
    private function getFormB() {
        $b = new b\B();
        if (
                key_exists('proprieta',$this->data) &&
                key_exists('cod_part',$this->data) &&
                key_exists('cod_fo',$this->data)
            )
        $b->loadFromCodePart($this->data['proprieta'],$this->data['cod_part'],$this->data['cod_fo']);
        return $b;
    }
     /**
     * Gets the associated B3 Shrub Composition Collection
     * @return \forest\attribute\shrubcomposition\B3Coll
     */
    public function getShrubCompositionColl() {
        $shrubcoll = new \forest\attribute\shrubcomposition\B3Coll();
        $shrubcoll->setForm($this);
        return $shrubcoll;
    }
     /**
     * Gets the associated B3 Herbaceus Composition Collection
     * @return \forest\attribute\herbaceuscomposition\B3Coll
     */
    public function getHerbaceusCompositionColl() {
        $herbaceuscoll = new \forest\attribute\herbaceuscomposition\B3Coll();
        $herbaceuscoll->setForm($this);
        return $herbaceuscoll;
    }
    /**
     * Gets the associated pasture weed collection
     * @return \forest\attribute\PastureWeedColl
     */
    public function getPastureWeedColl() {
        $pastureweedcoll = new \forest\attribute\PastureWeedColl();
        $pastureweedcoll->setForm($this);
        return $pastureweedcoll;
    }
     /**
     * Gets the associated B3 Cover Composition Collection
     * @return \forest\attribute\covercomposition\B3Coll
     */
    public function getCoverCompositionColl() {
        $b3covercompositioncoll = new \forest\attribute\covercomposition\B3Coll();
        $b3covercompositioncoll->setForm($this);
        return $b3covercompositioncoll;
    }
     /**
     * Gets the associated B3 Renovation Composition Collection
     * @return \forest\attribute\B3RenovationCompositionColl
     */
    public function getRenovationCompositionColl() {
        $b3renovationcompositioncoll = new \forest\attribute\B3RenovationCompositionColl();
        $b3renovationcompositioncoll->setForm($this);
        return $b3renovationcompositioncoll;
    }
    /**
     * Reassign u parameter to colt
     * @param type $data
     * @param string $field
     */
    public function setData($data, $field = null) {
        if (is_array($data) && key_exists('colt', $data))
            $data['u']=$data['colt'];
        else if ($field == 'colt')
            $field = 'u';
        parent::setData($data, $field);
    }
    /**
     * Reassign u parameter to colt
     * @param string $field
     */
    public function getData($field = null) {
        if ($field == 'colt')
            $field = 'u';
        return parent::getData($field);
    }
     /**
     * Gets the associated B3 Tree Line Composition Collection
     * @return \forest\attribute\B3TreeLineCompositionColl
     */
    public function getTreeLineCompositionColl() {
        $b3treelinecompositioncoll = new \forest\attribute\B3TreeLineCompositionColl();
        $b3treelinecompositioncoll->setForm($this);
        return $b3treelinecompositioncoll;
    }
} 
