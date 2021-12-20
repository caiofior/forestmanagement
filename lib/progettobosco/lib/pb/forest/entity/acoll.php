<?php
/**
 * Manages Entity A forest compartment collection
 * 
 * Manages Entity A forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity;
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
 * Manages Entity A forest compartment collection
 * 
 * Manages Entity A forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class AColl extends \forest\template\EntityColl {
    /**
     * Forest object
     * @var \forest\Forest
     */
    private $forest;
    /**
     * Workin Circle reference
     * @var \forest\WorkingCircle
     */
    private $workingcircle;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new \forest\entity\A());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->forest->getRawData('guest') === true) {
        $select->from($this->content->getTable()->info('name'), array(
            '*',
            'usosuolo' =>new \Zend_Db_Expr('( SELECT usosuolo.descriz FROM usosuolo 
            LEFT JOIN schede_b ON schede_b.u=usosuolo.codice
            WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part)'),
            'compresa' => new \Zend_Db_Expr(' (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                ) '),
            'descrizione' => new \Zend_Db_Expr(' (SELECT partcomp.abstract FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                ) ')
            
            )
        )
        ;    
        }
        else { 
        $select->from($this->content->getTable()->info('name'), array(
            '*',
            'usosuolo' =>new \Zend_Db_Expr('( SELECT usosuolo.descriz FROM usosuolo 
            LEFT JOIN schede_b ON schede_b.u=usosuolo.codice
            WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part)'),
            'rilevato' => new \Zend_Db_Expr(' (SELECT rilevato.descriz FROM rilevato
             WHERE rilevato.codice=schede_a.codiope) '),
            'compresa' => new \Zend_Db_Expr(' (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                ) '),
            'descrizione' => new \Zend_Db_Expr(' (SELECT partcomp.abstract FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                ) ')
            
            )
        )
        ;
        }
        if (key_exists('usosuolo', $criteria) && $criteria['usosuolo'] != '') {
           $select->where(new \Zend_Db_Expr('(SELECT schede_b.u FROM schede_b  WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part) = \''.$criteria['usosuolo'].'\''));
        }
        if (key_exists('codiope', $criteria) && $criteria['codiope'] != '') {
            $select->where('schede_a.codiope = ? ',$criteria['codiope']);
        }
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where('(schede_a.cod_part LIKE ? OR schede_a.toponimo  LIKE ? )','%'.$criteria['search'].'%');
        }
        if (
                (key_exists('parameter', $criteria) && $criteria['parameter'] != '') &&
                (key_exists('operator', $criteria) && $criteria['operator'] != '')
            ) {
            $archivecoll = \forest\template\ArchiveColl::getInstance();
            if (!is_array($criteria['parameter']))
                $criteria['parameter'] =array($criteria['parameter']);
            if (!is_array($criteria['operator']))
                $criteria['operator'] =array($criteria['operator']);
            if (!is_array($criteria['value']))
                $criteria['value'] =array($criteria['value']);
            foreach ($criteria['parameter'] as $key=>$parameter) {
                if (
                        !key_exists($key, $criteria['operator']) ||
                        !key_exists($key, $criteria['value'])
                    ) continue;
                $attribute = $archivecoll->getAttributeById($parameter);
                $select->where(
                        ' schede_a.objectid IN (
                            SELECT a'.$key.'.objectid FROM schede_a AS a'.$key.'
                            LEFT JOIN '.$attribute['archivio'].'
                            ON
                            a'.$key.'.proprieta = '.$attribute['archivio'].'.proprieta AND 
                            a'.$key.'.cod_part = '.$attribute['archivio'].'.cod_part    
                            WHERE
                            schede_a.proprieta = '.$attribute['archivio'].'.proprieta AND
                            schede_a.cod_part = '.$attribute['archivio'].'.cod_part AND
                            CAST('.$attribute['archivio'].'.'.$attribute['nomecampo'].' AS float) '.$criteria['operator'][$key].' '.floatval($criteria['value'][$key]).'
                            )
                        '
                );
            }
            }
        if (
                    $this->workingcircle instanceof \forest\WorkingCircle &&
                    $this->workingcircle->getData('objectid') != '' &&
                    key_exists('associated_compresa', $criteria) &&
                    $criteria['associated_compresa'] === true
                ) {
                    
                        $select->where('schede_a.proprieta = ?', $this->workingcircle->getData('proprieta'));
                        $select->where(' (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                )  = ? ',$this->workingcircle->getData('compresa'));
        }
        else if (
                    key_exists('associated_compresa', $criteria) &&
                    $criteria['associated_compresa'] === true
                ) {
                    
                        $select->where('FALSE');
        }
        else if (
                    $this->workingcircle instanceof \forest\WorkingCircle &&
                    $this->workingcircle->getData('objectid') != '' &&
                    key_exists('associated_compresa', $criteria) &&
                    $criteria['associated_compresa'] === false
                ) {
                    
                        $select->where('schede_a.proprieta = ?', $this->workingcircle->getData('proprieta'));
                        $select->where(' (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part
                )  <> ? OR
            (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part
                )  IS NULL    
            ',$this->workingcircle->getData('compresa'));
        }
        else if (
                $this->forest instanceof \forest\Forest &&
                $this->forest->getData('codice') != ''
                ) {
            $select->where('schede_a.proprieta = ?', $this->forest->getData('codice'));
        }
        $select->order('schede_a.cod_part');
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
     * Set the Workin Circle reference
     * @param \forest\WorkingCircle $workingcircle
     */
    public function setWorkingCircle($workingcircle) {
        $this->workingcircle = null;
        if ($workingcircle instanceof \forest\WorkingCircle)
            $this->workingcircle = $workingcircle;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
        if ($this->forest instanceof \forest\Forest || is_array($criteria)) {
            $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)');
             if (key_exists('usosuolo', $criteria) && $criteria['usosuolo'] != '') {
                $select->where(new \Zend_Db_Expr('(SELECT schede_b.u FROM schede_b  WHERE schede_b.proprieta=schede_a.proprieta AND schede_b.cod_part=schede_a.cod_part) = \''.$criteria['usosuolo'].'\''));
             }
             if (key_exists('codiope', $criteria) && $criteria['codiope'] != '') {
                 $select->where('schede_a.codiope = ? ',$criteria['codiope']);
             }
             if (key_exists('search', $criteria) && $criteria['search'] != '') {
                 $select->where('(schede_a.cod_part LIKE ? OR schede_a.toponimo  LIKE ? )','%'.$criteria['search'].'%');
             }
             if (
                (key_exists('parameter', $criteria) && $criteria['parameter'] != '') &&
                (key_exists('operator', $criteria) && $criteria['operator'] != '')
            ) {
            $archivecoll = \forest\template\ArchiveColl::getInstance();
            if (!is_array($criteria['parameter']))
                $criteria['parameter'] =array($criteria['parameter']);
            if (!is_array($criteria['operator']))
                $criteria['operator'] =array($criteria['operator']);
            if (!is_array($criteria['value']))
                $criteria['value'] =array($criteria['value']);
            foreach ($criteria['parameter'] as $key=>$parameter) {
                if (
                        !key_exists($key, $criteria['operator']) ||
                        !key_exists($key, $criteria['value'])
                    ) continue;
                $attribute = $archivecoll->getAttributeById($parameter);
                $select->where(
                        ' schede_a.objectid IN (
                            SELECT a'.$key.'.objectid FROM schede_a AS a'.$key.'
                            LEFT JOIN '.$attribute['archivio'].'
                            ON
                            a'.$key.'.proprieta = '.$attribute['archivio'].'.proprieta AND 
                            a'.$key.'.cod_part = '.$attribute['archivio'].'.cod_part    
                            WHERE
                            schede_a.proprieta = '.$attribute['archivio'].'.proprieta AND
                            schede_a.cod_part = '.$attribute['archivio'].'.cod_part AND
                            CAST('.$attribute['archivio'].'.'.$attribute['nomecampo'].' AS float) '.$criteria['operator'][$key].' '.floatval($criteria['value'][$key]).'
                            )
                        '
                );
            }
            }
             if (
                    $this->workingcircle instanceof \forest\WorkingCircle &&
                    $this->workingcircle->getData('objectid') != '' &&
                    key_exists('associated_compresa', $criteria) &&
                    $criteria['associated_compresa'] === true
                ) {
                    
                        $select->where('schede_a.proprieta = ?', $this->workingcircle->getData('proprieta'));
                        $select->where(' (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                )  = ? ',$this->workingcircle->getData('compresa'));
                }
                else if (
                            key_exists('associated_compresa', $criteria) &&
                            $criteria['associated_compresa'] === true
                        ) {

                                $select->where('FALSE');
                }
                else if (
                            $this->workingcircle instanceof \forest\WorkingCircle &&
                            $this->workingcircle->getData('objectid') != '' &&
                            key_exists('associated_compresa', $criteria) &&
                            $criteria['associated_compresa'] === false
                        ) {

                                $select->where('schede_a.proprieta = ?', $this->workingcircle->getData('proprieta'));
                                $select->where(' (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part 
                ) <> ? OR
            (SELECT partcomp.compresa FROM partcomp
             WHERE
             partcomp.proprieta=schede_a.proprieta AND
             partcomp.cod_part=schede_a.cod_part
                )  IS NULL 
                ',$this->workingcircle->getData('compresa'));
                }
                else if (
                $this->forest instanceof \forest\Forest  &&
                $this->forest->getData('codice') != '') {
                 $select->where('schede_a.proprieta = ?', $this->forest->getData('codice'));
             }
            return intval($this->content->getTable()->getAdapter()->fetchOne($select));
        }
        else 
            return parent::countAll();

    }
     /**
     * Adds new item to the form
     * @return \forest\entity\A
     */
    public function addItem() {
        $a = parent::addItem();
        $a->setData($this->forest->getData('codice'),'proprieta');
        return $a;
    }

}
