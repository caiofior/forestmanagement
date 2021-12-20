<?php
/**
 * Manages Soil use attribute collection
 * 
 * Manages Soil use attribute collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
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
 * Manages Soil use attribute collection
 * 
 * Manages Soil use attribute collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class SoilUseColl  extends \ContentColl implements \forest\template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new SoilUse());
    }
    /**
     * Sets the forest reference
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        if ($this->forest instanceof \forest\Forest) {
            $select->setIntegrityCheck(false)
            ->where(new \Zend_Db_Expr(' usosuolo.codice IN (SELECT schede_b.u FROM schede_b WHERE schede_b.proprieta =  ? )'),$this->forest->getData('codice'));        
        }
        $select->order('descriz');
        return $select;
    }
}
