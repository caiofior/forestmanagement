<?php
/**
 * Manages User account collection
 * 
 * Manages User account collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages User account collection
 * 
 * Manages User account collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class UserColl extends ContentColl {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new User());
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false); 
        $select->from('user',array('*','user_id'=>'id'));
        $select->join('profile','profile.id = '.$select->getAdapter()->quoteIdentifier('user').'.profile_id');
        if (key_exists('search', $criteria)) {
            $select->where('username LIKE ?', $criteria['search'].'%');
            $select->orWhere('first_name LIKE ?', $criteria['search'].'%');
            $select->orWhere('address_city LIKE ?', $criteria['search'].'%');
            $select->orWhere('phone LIKE ?', $criteria['search'].'%');
            $select->orWhere('organization LIKE ?', $criteria['search'].'%');
        }
        return $select;
    }
}