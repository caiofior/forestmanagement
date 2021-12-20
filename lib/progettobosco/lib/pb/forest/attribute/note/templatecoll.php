<?php
/**
 * Manages Note collection
 * 
 * Manages Note collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute\note;

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
 * Manages Note collection
 * 
 * Manages Note collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class TemplateColl  extends \ContentColl  {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\attribute\note\Template());
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
            $select->where('intesta LIKE ?', '%'.$criteria['search'].'%');   
        }
        if (key_exists('archivio', $criteria) && $criteria['archivio'] != '') {
            $select->where('LOWER(archivio) = LOWER(?)', $criteria['archivio']);   
        }
        $select->order('intesta');
        return $select;
    }
}
