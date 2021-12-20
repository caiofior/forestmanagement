<?php
/**
 * Manages Entity E forest compartment Collection
 * 
 * Manages Entity E forest compartment Collection
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
 * Manages Entity E forest compartment Collection
 * 
 * Manages Entity E forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class EColl extends \forest\template\EntityColl {
    /**
     * Forest object
     * @var \forest\Forest
     */
    private $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\e\E());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if (key_exists('codiope', $criteria) && $criteria['codiope'] != '') {
                 $select->where('schede_e.codiope = ? ',$criteria['codiope']);
        }
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
                 $select->where('(schede_e.nome_strada LIKE ? OR schede_e.da_valle  LIKE ? OR schede_e.a_monte  LIKE ? )','%'.$criteria['search'].'%');
        }
        if ($this->forest instanceof \forest\Forest) {
                 $select->where('schede_e.proprieta = ?', $this->forest->getData('codice'));
        }
        return $select;
    }
    /**
     * Sets forest compartment forest
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->forest instanceof \forest\Forest || is_array($criteria)) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
             if (key_exists('codiope', $criteria) && $criteria['codiope'] != '') {
                 $select->where('schede_e.codiope = ? ',$criteria['codiope']);
             }
             if (key_exists('search', $criteria) && $criteria['search'] != '') {
                 $select->where('(schede_e.nome_strada LIKE ? OR schede_e.da_valle  LIKE ? OR schede_e.a_monte  LIKE ? )','%'.$criteria['search'].'%');
             }
             if ($this->forest instanceof \forest\Forest) {
                 $select->where('schede_e.proprieta = ?', $this->forest->getData('codice'));
             }
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
     /**
     * Adds new item to the form
     * @return \forest\entity\E
     */
    public function addItem() {
        $e = parent::addItem();
        $e->setData($this->forest->getData('codice'),'proprieta');
        return $e;
    }


}
