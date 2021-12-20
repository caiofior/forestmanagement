<?php
/**
 * Manages Workin Circle
 * 
 * Manages Workin Circle
 * 
 * @link https://it.wikipedia.org/wiki/Comprese
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest;


if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Workin Circle
 * 
 * Manages Workin Circle
 * 
 * @link https://it.wikipedia.org/wiki/Comprese
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class WorkingCircle extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('compresa');
    }
    /**
     * Loads form a data
     * @param integer $id
     * @throws Exception
     */
    public function loadFromId($id) {
        if (!is_numeric($id))
            throw new \Exception ('ID is not valid',1705130906);
        parent::loadFromId($id);
        $this->calculatedVariables();
    }
    /**
     * Return the forest associate with a form
     * @return \forest\Forest
     */
    public function getForest() {
        $forest = new \forest\Forest();
        if (!key_exists('proprieta', $this->data))
                throw new \Exception ('Working Circle not associated with a forest',0705131053);
        $forest->loadFromCode($this->data['proprieta']);
        $forest->setWorkingCircle($this);
        return $forest;
    }
    /**
     * Sets the calculated variables
     */
    private function calculatedVariables () {
        
    }
    /**
     * Add a form a forest compartment to a working circle
     * @param \forest\entity\A $forma
     * @throws \Exception
     */
    public function addFormA(\forest\entity\A $forma) {
        $forest = $this->getForest();
        $table = new \Zend_Db_Table('partcomp');
        /*try{*/
        $table->insert(array(
           'proprieta'=> $forest->getData('codice'),
           'cod_part'=> $forma->getData('cod_part'),
           'cod_fo'=> $forma->getData('cod_fo'),
           'compresa'=>$this->data['compresa']
        ));
        /*} catch (\Exception $e) {
            
            if (strpos($e->getMessage(), 'duplicate key value violates unique constraint'))
                throw new \Exception('Forest compartment already present in working circle',0905131149);
            else
                throw $e;
        }*/
    }
    /**
     * Removes a form a forest compartment from a working circle
     * @param \forest\entity\A $forma
     */
    public function removeFormA (\forest\entity\A $forma) {
        $forest = $this->getForest();
        $table = new \Zend_Db_Table('partcomp');
        $where = $table->getAdapter()->quoteInto('proprieta = ?', $forest->getData('codice'));
        $where .= $table->getAdapter()->quoteInto('AND cod_part = ?', $forma->getData('cod_part'));
        $where .= $table->getAdapter()->quoteInto('AND cod_fo = ?', $forma->getData('cod_fo'));
        $where .= $table->getAdapter()->quoteInto('AND compresa = ?', $this->data['compresa']);
        $table->delete($where);
        
    }
} 
