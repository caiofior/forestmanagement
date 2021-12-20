<?php
/**
 * Manages Arboreal collection
 * 
 * Manages Arboreal collection
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
 * Manages Arboreal collection
 * 
 * Manages Arboreal collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ArborealColl  extends \ContentColl  {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Arboreal());
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
        if (key_exists('b1_objectid', $criteria) && $criteria['b1_objectid'] != '' && key_exists('shrub', $criteria)) {
            $select->where(new \Zend_Db_Expr(' NOT cod_coltu IN ( 
                SELECT cod_coltu FROM arbusti 
                    LEFT JOIN sched_b1 ON
                    arbusti.proprieta=sched_b1.proprieta AND
                    arbusti.cod_part=sched_b1.cod_part AND
                    arbusti.cod_fo=sched_b1.cod_fo
                WHERE sched_b1.objectid=\''.intval($criteria['b1_objectid']).'\'
            )'));
        } else if (key_exists('b1_objectid', $criteria) && $criteria['b1_objectid'] != '' && key_exists('mass_esteem', $criteria)) {
            $select->where(new \Zend_Db_Expr(' NOT cod_coltu IN ( 
                SELECT cod_coltu FROM stime_b1 
                    LEFT JOIN sched_b1 ON
                    stime_b1.proprieta=sched_b1.proprieta AND
                    stime_b1.cod_part=sched_b1.cod_part AND
                    stime_b1.cod_fo=sched_b1.cod_fo
                WHERE sched_b1.objectid=\''.intval($criteria['b1_objectid']).'\'
            )'));
        } else if (key_exists('b1_objectid', $criteria) && $criteria['b1_objectid'] != '') {
            $select->where(new \Zend_Db_Expr(' NOT cod_coltu IN ( 
                SELECT cod_coltu FROM arboree 
                    LEFT JOIN sched_b1 ON
                    arboree.proprieta=sched_b1.proprieta AND
                    arboree.cod_part=sched_b1.cod_part AND
                    arboree.cod_fo=sched_b1.cod_fo
                WHERE sched_b1.objectid=\''.intval($criteria['b1_objectid']).'\'
            )'));
        }
        $select->order('nome_itali')->order('nome_scien');
        return $select;
    }
}
