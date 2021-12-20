<?php
/**
 * Manages Poligon collection
 * 
 * Manages Poligon collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\geo;
if (!class_exists('Content')) {
    $file = array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Forest collection
 * 
 * Manages Forest collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class PolygonColl extends \ContentColl {
     /**
     * SQL reference
     * @var string
     */
    private static $sql;
    /**
     * Referencnce to forest object
     * @var null|\forest\Forest
     */
    private $forest;
    /**
     * Collection data
     * @var array
     */
    private $data = array();
    /**
     * Instantiates the table
     * @param string $name Table name
     */
    public function __construct($name) {
        parent::__construct(new Polygon($name));
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false);
        if ($this->forest instanceof \forest\Forest) {
            $select->where(new \Zend_Db_Expr($this->content->getTable()->info('name').'.id_av IN (SELECT schede_a.id_av FROM schede_a  WHERE schede_a.proprieta= '.$select->getAdapter()->quote($this->forest->getData('codice')).')'));
        }
        return $select;
    }
    /**
     * Returns all contents without any filter
     * @param null|array $criteria Filtering criteria
     */
    public function countAll(array $criteria = null) {
            parent::countAll();
    }
    /**
     * Sets the forest Filter
     * @param \forest\Forest $forest
     */
    public function setForest (\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Manages errors in polygon
     * @param int $num
     * @param string $err
     * @param string $file
     * @param int $line
     */
    public static function error_handler ($num,$err,$file, $line) {
        trigger_error('Error on insert '.$file.' '.$line.' '.$err);
        file_put_contents($GLOBALS['BASE_DIR'].'log'.DIRECTORY_SEPARATOR.'last_wrong_query.sql', self::$sql);
    }
    /**
     * get Centroid Point
     * @return \gPoint
     */
    public function getCentroid () {
        if (!key_exists('centroid',$this->data)) {
            
            switch (get_class($this->content->getTable()->getAdapter())) {
                case 'Zend_Db_Adapter_Mysqli':
                    $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'), array(
                        'X'=> new \Zend_Db_Expr('SUM(X(Centroid(poligon))*Area(poligon))/ (SELECT SUM(Area(poligon)) FROM geo_particellare AS g3 WHERE g3.id_av IN (SELECT id_av FROM schede_a))'),
                        'Y'=> new \Zend_Db_Expr('SUM(Y(Centroid(poligon))*Area(poligon))/ (SELECT SUM(Area(poligon)) FROM geo_particellare AS g3 WHERE g3.id_av IN (SELECT id_av FROM schede_a))'),
                        'zone'=>new \Zend_Db_Expr('(SELECT g2.zone FROM geo_particellare AS g2 WHERE g2.id_av=MIN(geo_particellare.id_av) LIMIT 1)'),
                        'forest'=>new \Zend_Db_Expr('(SELECT schede_a.proprieta FROM schede_a WHERE schede_a.id_av= geo_particellare.id_av)')
                    ));
                    $select = $this->customSelect($select, array());
                    $select->group('forest');
                    self::$sql = $select->assemble();
                    $point = $this->content->getTable()->getAdapter()->fetchRow(self::$sql);
                    $gpoint = new \gPoint();
                    $gpoint->setUTM($point['X'], $point['Y'], $point['zone']);
                    $gpoint->convertTMtoLL();
                    $this->data['centroid']=$gpoint;
                break;
                case 'Zend_Db_Adapter_Pgsql':
                    $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'), array(
                        'xy'=> new \Zend_Db_Expr('ST_AsGeoJson(ST_Centroid(ST_Multi(ST_Union(poligon))))'),
                        'zone'=>new \Zend_Db_Expr('(SELECT g2."zone" FROM geo_particellare AS g2 WHERE g2.id_av=MIN(geo_particellare.id_av) LIMIT 1)'),
                        'forest'=>new \Zend_Db_Expr('(SELECT schede_a.proprieta FROM schede_a WHERE schede_a.id_av= geo_particellare.id_av)')
                    ));
                    $select = $this->customSelect($select, array());
                    $select->group('forest');
                    self::$sql = $select->assemble();
                    set_error_handler(get_class($this).'::error_handler');
                    $point = $this->content->getTable()->getAdapter()->fetchRow(self::$sql);
                    restore_error_handler();
                    $jpoint = json_decode($point['xy']);
                    $gpoint = new \gPoint();
                    $gpoint->setUTM($jpoint->coordinates[0], $jpoint->coordinates[1],$point['zone']);
                    $gpoint->convertTMtoLL();
                    $this->data['centroid']=$gpoint;
                break;

            }
        }
        return $this->data['centroid'];
    }
    /**
     * Return the collection polygon area
     * @return float
     */
    public function getArea () {
        if (!key_exists('area',$this->data)) {
            switch (get_class($this->content->getTable()->getAdapter())) {
                case 'Zend_Db_Adapter_Mysqli':
                    $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'), array(
                        'area'=> new \Zend_Db_Expr('SUM(Area(poligon))'),
                        'forest'=>new \Zend_Db_Expr('(SELECT schede_a.proprieta FROM schede_a WHERE schede_a.id_av= geo_particellare.id_av)')
                    ));
                    $select = $this->customSelect($select, array());
                    $select->group('forest');
                    self::$sql = $select->assemble(); 
                    set_error_handler(get_class($this).'::error_handler');
                    $area = $this->content->getTable()->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $this->data['area']=$area;
                break;
                case 'Zend_Db_Adapter_Pgsql':
                    $select = $this->content->getTable()->select()->from($this->content->getTable()->info('name'), array(
                        'area'=> new \Zend_Db_Expr('ST_Area(ST_Multi(ST_Union(poligon)))'),
                        'forest'=>new \Zend_Db_Expr('(SELECT schede_a.proprieta FROM schede_a WHERE schede_a.id_av= geo_particellare.id_av)')
                    ));
                    $select = $this->customSelect($select, array());
                    $select->group('forest');
                    self::$sql = $select->assemble();
                    set_error_handler(get_class($this).'::error_handler');
                    $area = $this->content->getTable()->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $this->data['area']=$area;
                break;

            }
        }
        return $this->data['area'];
    }
}