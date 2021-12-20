<?php
/**
 * Manages Data collector collection
 * 
 * Manages Data collector collection
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
 * Manages Data collector collection
 * 
 * Manages Data collector collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class CollectorColl  extends \ContentColl implements \forest\template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Collector());
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
        $select->setIntegrityCheck(false)
        ->from($this->content->getTable()->info('name'));
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where('LOWER(descriz) LIKE LOWER(?) ','%'.$criteria['search'].'%');
        }
        if ($this->forest instanceof \forest\Forest) {
            $select->where(new \Zend_Db_Expr(' rilevato.codice IN (SELECT schede_a.codiope FROM schede_a WHERE schede_a.proprieta =  ? )'),$this->forest->getData('codice'));        
        }
        $select->order('descriz');
        return $select;
    }
}
