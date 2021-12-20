<?php
/**
 * Manages Region collection
 * 
 * Manages Region collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest;
if (!class_exists('Content')) {
    $file = array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Region collection
 * 
 * Manages Region collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class RegionColl extends \ContentColl {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Region());
    }
      /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        if (key_exists('filter_forest', $criteria)) {
                $select = $this->content->getTable()->select($this->content->getTable()->info('name'));
                $select->setIntegrityCheck(false)
                ->join('propriet','diz_regioni.codice = propriet.regione',array())->group('diz_regioni.codice');
        }
        $select->order('descriz');
        return $select;
    }
}