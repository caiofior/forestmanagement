<?php
/**
 * Manages User account
 * 
 * Manages User account
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages User account
 * 
 * Manages User account
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class User extends Content {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('user');
        $this->empty_entity['password_new']=null;
    }
    /**
     * Loads user from its id
     * @param int $id
     */
    public function loadFromId($id) {
        $where = $this->table->getAdapter()->quoteInto('id = ?', $id); 
        $updated = $this->table->update(array('lastlogin_datetime'=>new \Zend_Db_Expr('NOW()')), $where);
        parent::loadFromId($id);
        if (
                !is_array($this->data) ||
                !key_exists('id', $this->data) ||
                !is_numeric($this->data['id'])
                )
                throw new \Exception('User not found',1301130904);
    }
     /**
     * Loads user from its username
     * @param string $username
     */
    public function loadFromUsername($username) {
        $where = $this->table->getAdapter()->quoteInto('username = ?', $username); 
        $updated = $this->table->update(array('lastlogin_datetime'=>new \Zend_Db_Expr('NOW()')), $where);
        $data = $this->table->fetchRow($where);
        if (is_object($data))
            $this->data = $data->toArray();
        if (
        !is_array($this->data) ||
        !key_exists('id', $this->data) ||
        !is_numeric($this->data['id'])
        )
        throw new \Exception('User not found',1301130904);
    }
     /**
     * Loads user from its confirmation code
     * @param string $confirmation_code Confirmation code
     */
    public function loadFromConformationCode($confirmation_code) {
        $where = $this->table->getAdapter()->quoteInto('confirmation_code = ?', $confirmation_code); 
        $updated = $this->table->update(array('lastlogin_datetime'=>new \Zend_Db_Expr('NOW()')), $where);
        $this->data = $this->table->fetchRow($where)->toArray();
                if (
                !is_array($this->data) ||
                !key_exists('id', $this->data) ||
                !is_numeric($this->data['id'])
                )
                throw new \Exception('User not found',1301130904);
    }
    /**
     * Adds a new user, please save the password in clear in password_new
     */
    public function insert() {
        if (!key_exists('username', $this->data) || $this->data['username'] == '')
          throw new Exception ('username is required ',130113906);
        if (!key_exists('password_new', $this->data) || $this->data['password_new'] == '')
          throw new Exception ('password_new is required ',130113907);
        $rows = $this->table->fetchAll($this->table->select()->where('username = ?', $this->data['username']));
        if (sizeof($rows) <> 0)
            throw new Exception ('User with username '.$this->data['username'].' already present',130113905);
        $this->data['password']=md5($this->data['password_new']);
        unset($this->data['password_new']);
        $this->data['confirmation_code']=md5(serialize($GLOBALS));
        $this->data['creation_datetime']=new \Zend_Db_Expr('NOW()');
        $profile = new Profile();
        $profile->setData($this->data['username'],'email');
        $profile->insert();
        $this->data['profile_id']=$profile->getData('id');
        parent::insert();
    }
    /**
     * Updates user data
     */
    public function update() {
        $rows = array();
        if (key_exists('username', $this->data))
            $rows = $this->table->fetchAll($this->table->select()->where('username = ?', $this->data['username']));
        else $this->data['username'] = '';
        if (sizeof($rows) <> 1)
            throw new Exception ('User with username '.$this->data['username'].' not present',130113905);
        if (key_exists('password_new', $this->data)) {
            $this->data['password']=md5($this->data['password_new']);
            unset($this->data['password_new']);
        }
        parent::update();
    }
    /**
     * Gets associated profile to the user
     * @return Profile
     */
    public function getProfile() {
        $profile = new Profile();
        if (is_array($this->data)  && key_exists('id', $this->data)) {
            try{
                $profile->loadFromId($this->data['id']);
            } catch (Exception $e) {
                $profile->insert();
                $this->data['profile_id']=$profile->getData('id');
                $this->update();
            }
        }
        return $profile;
    }
    /**
     * Creates user auth class
     * @return \Zend_Auth_Adapter_DbTable
     */
    public static function getAuthAdapter()    {
        return new Zend_Auth_Adapter_DbTable(
    Zend_Db_Table::getDefaultAdapter(),
    'user',
    'username',
    'password',
    'MD5(?) AND '.Zend_Db_Table::getDefaultAdapter()->quoteIdentifier('active').' AND '.Zend_Db_Table::getDefaultAdapter()->quoteIdentifier('confirmed').''
);
    }
    /**
     * Check password consistence
     * @param string $new_password
     * @return bool
     */
    public function checkPassword($new_password) {
        return md5($new_password) != $this->data['password'];
    }
    /**
    * Generates a new password
    * @param int $n number of charcaters
    * @return string password
    */
   public function generatePassword ($n=null) {
        if (is_null($n))  $n = 6;
        
        $password = '';
        for ($c  = 0; $c < 6 ; $c++)
                $password .= ((rand(1,4) != 1) ? chr(rand(97, 122)) : rand(0, 9));
        $this->data['password_new']=$password;
        return $password;
   }
   /**
    * Remaps user id value
    * @param variant $data
    * @param string|null $field
    */
   public function setData($data, $field = null) {
       if (is_array($data) && key_exists('user_id', $data))
               $data['id']=$data['user_id'];
       parent::setData($data, $field);
   }
   /**
    * Return the forrest collection
    * @param bool $filtered Set id data has to be filtered by user
    * @return \forest\ForestColl
    */
   public function getForestColl($filtered = false) {
       $forestcoll = new \forest\ForestColl();
       $forestcoll->setUserForests($this);
       $forestcoll->setFilterByUser($filtered);
       return $forestcoll;
   }
   /**
    * Check if a user manages a forest
    * @param forest\Forest $forest
    * @return boolean
    */
   public function isUserForestAdmin(forest\Forest $forest ) {
       if (
               key_exists('is_admin', $this->data) && 
                ($this->data['is_admin'] == 't' || $this->data['is_admin'] == 1)
        )
           return true;
       if (!is_array($forest->getRawData()) || !$forest->getRawData('write_users'))
           return false;
       return in_array($this->data['id'],$forest->getRawData('write_users'));
   }
   /**
    * Check if user is admin
    * @return bool
    */
   public function isAdmin ()  {
       return 
               key_exists('is_admin', $this->data) &&
               ($this->data['is_admin'] == 't' || $this->data['is_admin'] == 1);
   }
}