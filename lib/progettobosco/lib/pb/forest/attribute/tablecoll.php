<?php
/**
 * Manages Table collection
 * 
 * Manages Table collection
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
 * Manages Table collection
 * 
 * Manages Table collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class TableColl  extends \ContentColl  {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Table());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('diz_tavole',array(
            '*',
            'tipo_descriz'=>new \Zend_Db_Expr(
                '( SELECT tipo_tavola.tipo_tavola FROM tipo_tavola WHERE tipo_tavola.codice=diz_tavole.tipo) '
             )
        ));
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where(' (
                    LOWER(descriz) LIKE LOWER(?) OR
                    LOWER(codice) LIKE LOWER(?) OR
                    LOWER(autore) LIKE LOWER(?)
                ) ', '%'.$criteria['search'].'%');   
        }
        if (key_exists('tipo', $criteria) && $criteria['tipo'] != '') {
            $select->where(' tipo = ? ', $criteria['tipo']);   
        }
        return $select;
    }
}
