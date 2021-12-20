<?php
/**
 * Manages Manages Piu 2/3  collection
 * 
 * Manages Manages Piu 2/3  collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
  */
namespace forest\attribute\template;
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
 * Manages Manages Piu 2/3  collection
 * 
 * Manages Manages Piu 2/3  collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
  */
abstract class Piu2_3Coll  extends \ContentColl implements \forest\template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
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
        return $select;
    }
}
