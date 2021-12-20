<?php
/**
 * Manages Herbacea collection
 * 
 * Manages Herbacea collection
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
 * Manages Herbacea collection
 * 
 * Manages Herbacea collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class HerbaceaColl  extends \ContentColl  {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Herbacea());
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
            $select->where(' LOWER(nome_itali) LIKE LOWER(?) OR LOWER(nome_scien) LIKE LOWER(?) ', '%'.$criteria['search'].'%');   
        }
        if (key_exists('b1_objectid', $criteria) && $criteria['b1_objectid'] != '' ) {
            $select->where(new \Zend_Db_Expr(' NOT cod_coltu IN ( 
                SELECT cod_coltu FROM erbacee 
                    LEFT JOIN sched_b1 ON
                    erbacee.proprieta=sched_b1.proprieta AND
                    erbacee.cod_part=sched_b1.cod_part AND
                    erbacee.cod_fo=sched_b1.cod_fo
                WHERE sched_b1.objectid=\''.intval($criteria['b1_objectid']).'\'
            )'));
        } 
        $select->order('nome');
        return $select;
    }
}
