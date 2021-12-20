<?php
/**
 * Manages Viability Intervent collection
 * 
 * Manages Viability Intervent collection
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
 * Manages Viability Intervent collection
 * 
 * Manages Viability Intervent collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ViabilityInterventColl  extends \ContentColl implements \forest\template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new ViabilityIntervent());
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
        $select->setIntegrityCheck(false);
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where('LOWER(descriz) LIKE LOWER(?) ','%'.$criteria['search'].'%');
        }
        $select->order('descriz');
        return $select;
    }
}
