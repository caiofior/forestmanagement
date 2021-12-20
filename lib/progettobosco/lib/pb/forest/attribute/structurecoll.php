<?php
/**
 * Manages Stucture collection
 * 
 * Manages Stucture collection
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
 * Manages Stucture collection
 * 
 * Manages Stucture collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class StructureColl  extends \ContentColl implements \forest\template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Structure());
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
        if (key_exists('codice_bosco', $criteria) && $criteria['codice_bosco'] != '') {
            $select->where(new \Zend_Db_Expr('regione = ( SELECT regione FROM propriet WHERE codice=\''.intval($criteria['codice_bosco']).'\')'))
            ->orWhere('regione = \'00\'');
        }
        $select->order('descriz');
        return $select;
    }
}
