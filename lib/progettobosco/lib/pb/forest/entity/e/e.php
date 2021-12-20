<?php
/**
 * Manages Entity E forest compartment
 * 
 * Manages Entity E forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\e;
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
 * Manages Entity E forest compartment
 * 
 * Manages Entity E forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class E extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_e');
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
     * Sets the calculated variables
     */
    private function calculatedVariables () {
       
    }
     /**
     * Updates data
     */
    public function update() {
        if (!key_exists('proprieta', $this->data) ||
            !key_exists('strada', $this->data) 
            ) 
            throw new \Exception('Unable to update object without proprieta,cod_part and cod_fo',1301251130);
        foreach($this->data as $key=>$value)
        $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
        $where .= $this->table->getAdapter()->quoteInto('strada= ? AND ', $this->data['strada']);
        $this->table->update($this->data, $where);
    }
    /**
     * Deletes data
     */
    public function delete() {
            $where = $this->table->getAdapter()->quoteInto('proprieta = ? AND ', $this->data['proprieta']);
            $where .= $this->table->getAdapter()->quoteInto('strada = ? AND ', $this->data['strada']);
            $this->table->delete($where);
    }
     /**
     * Gets the associated collector
     * @return \forest\attribute\Collector
     */
    public function getCollector() {
        $collector = new \forest\attribute\Collector();
        if (key_exists('codiope', $this->data))
            $collector->loadFromId($this->data['codiope']);
        return $collector;
    }
     /**
     * Return the associated E1 Collection
     * @return \forest\entity\e\E1Coll
     */
    public function getE1Coll () {
        $e1coll = new \forest\entity\e\E1Coll();
        $e1coll->setFormE($this);
        $e1coll->loadAll();
        return $e1coll;
    }
  
} 
