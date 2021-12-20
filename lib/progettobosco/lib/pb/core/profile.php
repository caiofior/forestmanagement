<?php
/**
 * Manages User profile
 * 
 * Manages User profile
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages User profile
 * 
 * Manages User profile
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Profile extends Content {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('profile');
    }
     /**
     * Loads profile from its id
     * @param int $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        if (is_null($this->data))
            throw new Exception('Unable to find the profile',1301141428);
    }
    /**
     * Adds a new user, please save the password in clear in password_new
     */
    public function insert() {
        $this->data['lastupdate_datetime']=new \Zend_Db_Expr('NOW()');
        parent::insert();
    }
    /**
     * Updates user data
     */
    public function update() {
        $this->data['lastupdate_datetime']=new \Zend_Db_Expr('NOW()');
        parent::update();
    }
}

