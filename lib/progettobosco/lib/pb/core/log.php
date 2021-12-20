<?php
/**
 * Logs user data
 * 
 * Logs user data
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Logs user data
 * 
 * Logs user data
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Log extends Content {
    /**
     * Delete old records in pg db
     */
    const CLEANUP_LOG_PG =  " creation_datetime < NOW() - INTERVAL '1 month'";
    /**
     * Delete old records in mysql db
     */
    const CLEANUP_LOG_MYSQL =  " creation_datetime < DATE_SUB(NOW(), INTERVAL 1 MONTH)";
    
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('log');
        
        switch (get_class($this->table->getAdapter())) {
            case 'Zend_Db_Adapter_Mysqli':
                $this->table->delete(self::CLEANUP_LOG_MYSQL);
            break;
            case 'Zend_Db_Adapter_Pgsql':
                $this->table->delete(self::CLEANUP_LOG_PG);
            break;
        }
        
        
    }
    /**
     * Loads profile from its id
     * @param int $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        if (is_null($this->data))
            throw new Exception('Unable to find the log',1301151428);
    }
    /**
     * Adds a new log entry
     */
    public function insert() {
        $this->data['creation_datetime']='NOW()';
        parent::insert();
    }

}

