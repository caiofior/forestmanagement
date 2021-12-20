<?php
/**
 * Manages Geographic Polygon
 * 
 * Manages Geographic Polygon
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\geo;
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
 * Manages Geographic Polygon
 * 
 * Manages Geographic Polygon
 * Data are stored in database in UTM format using Ellipsoid WGS 84
 * {@link http://www.phpclasses.org/browse/file/10671.html gPoint Tool} was user for transformation  for transforming Latitude and Longitude to UTM
 * 
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Polygon  extends \Content  {
    /**
     * Collection of poligon items
     * @var array
     */
    private $items =array();
    /**
     * Raw coordinates
     * @var array
     */
    private $coordinates = array();
    /**
     * Collection of semplified poligon items
     * @var array
     */
    private $semplified=array();
    /**
     * Bound limits
     * @var array
     */
    private $bounds=array();
    /**
     * SQL reference
     * @var string
     */
    private static $sql;
    /**
     * Instantiates the table
     * @param string $name table name
     */
    public function __construct($name) {
        try {
            parent::__construct($name);
        } catch (\Exception $e) {
            throw new \Exception('Table name is required',1423220513);
        }
    }
    /**
     * Sets the reference to the vector
     * @param type $id
     * @throws Exception 
     */
    public function loadFromId($id) {
        $count = $this->table->getAdapter()->fetchOne('SELECT COUNT(id_av) FROM '.$this->table->info('name').' WHERE id_av='.$this->table->getAdapter()->quote($id));
        if ($count <> 1)
            throw new \Exception('Geographic data not found',1217230513);
        $this->data['id_av'] = $id;
    }
    /**
     * Sets the id av of a new poligon
     * @param string $id
     */
    public function setIdAv ($id) {
        $this->data = array();
        $this->data['id_av'] = $id;
    }

    /**
     * Returns a new polygon vertex
     * @return \forest\geo\PolygonItem
     */
    public function appendItem() {
        $polygon = new \forest\geo\PolygonItem();
        $polygon->setData($this->data['id_av'], 'id_av');
        $this->items[] = $polygon;
        return $polygon;
    }
    /**
     * Returns a new semplified polygon vertex
     * @return \forest\geo\PolygonItem
     */
    public function appendSemplifiedItem() {
        $polygon = new \forest\geo\PolygonItem();
        $polygon->setData($this->data['id_av'], 'id_av');
        $this->semplified[] = $polygon;
        return $polygon;
    }
    /**
     * Insert a polygon to db
     */
    public function insert() {
        $this->table->getAdapter()->query('DELETE FROM '.$this->table->info('name').' WHERE id_av = '.$this->table->getAdapter()->quote($this->data['id_av']));
        $gpoint = new \gPoint();
        switch (get_class($this->table->getAdapter())) {
            case 'Zend_Db_Adapter_Mysqli':
            self::$sql = 'INSERT INTO '.$this->table->info('name').' (id_av, poligon,zone) '.
                   ' VALUES ('.$this->table->getAdapter()->quote($this->data['id_av']).' ,  GeomFromText(\'POLYGON ((';
            foreach ($this->items as $key=>$point) {
                $gpoint->setLongLat($point->getRawData('longitude'),$point->getRawData('latitude'));
                $gpoint->convertLLtoTM();
                if ($key > 0 ) self::$sql .= ', ';
                 self::$sql .= $gpoint->E().' '.$gpoint->N();
            }
            self::$sql .= '))\'),"'.$gpoint->Z().'")';
            $db = $this->table->getAdapter()->getConnection();
            set_error_handler(get_class($this).'::error_handler');
            mysqli_query($db, self::$sql);
            restore_error_handler();
            break;
            case 'Zend_Db_Adapter_Pgsql':
        
            self::$sql = 'INSERT INTO '.$this->table->info('name').' (id_av, poligon, zone) '.
                   ' VALUES ('.$this->table->getAdapter()->quote($this->data['id_av']).' , ST_GeomFromText(\'POLYGON((';
            $first = null;    
            foreach ($this->items as $key=>$point) {
                $gpoint->setLongLat($point->getRawData('longitude'),$point->getRawData('latitude'));
                $gpoint->convertLLtoTM();
                if ($key == 0)
                    $first = clone $gpoint;
                self::$sql .= $gpoint->E().' '.$gpoint->N().', ';
            }
            self::$sql .= $first->E().' '.$first->N();
            self::$sql .= '))\',4326),\''.$first->Z().'\')';

            $db = $this->table->getAdapter()->getConnection();
            set_error_handler(get_class($this).'::error_handler');
            pg_query($db, self::$sql);
            restore_error_handler();
            break;
        }
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
     * Returns a collection of vertex
     * @return array
     */
    public function getVertexColl()  {
        if (sizeof($this->items) == 0) {
            $this->bounds['E']=array('min'=>PHP_INT_MAX,'max'=>0);
            $this->bounds['N']=array('min'=>PHP_INT_MAX,'max'=>0);
            switch (get_class($this->table->getAdapter())) {
               case 'Zend_Db_Adapter_Mysqli':
                   self::$sql = 'SELECT AsText(poligon) as XY , zone FROM '.$this->table->info('name').' WHERE id_av = "'.$this->data['id_av'].'"';
                   set_error_handler(get_class($this).'::error_handler');
                   $point = $this->table->getAdapter()->fetchRow(self::$sql);
                   restore_error_handler();
                   $jpointcoll = explode(',',str_replace(array('POLYGON((','))'), '', $point['XY']));
                   $gpoint = new \gPoint();
                   foreach($jpointcoll as $jpoint) {
                        $jpoint = explode(' ', $jpoint);
                        $poligonitem = $this->appendItem();

                        $gpoint->setUTM($jpoint[0], $jpoint[1],$point['zone']);
                        $gpoint->convertTMtoLL();
                        $poligonitem->setData(array(
                            'latitude'=>$gpoint->Lat(),
                            'longitude'=>$gpoint->Long(),
                        ));
                        $this->coordinates[]=array('E'=>$gpoint->Long(),'N'=>$gpoint->Lat());
                        
                        $this->bounds['E']['min'] = min ($this->bounds['E']['min'],$gpoint->Long());
                        $this->bounds['E']['max'] = max ($this->bounds['E']['max'],$gpoint->Long());
                        $this->bounds['N']['min'] = min ($this->bounds['N']['min'],$gpoint->Lat());
                        $this->bounds['N']['max'] = max ($this->bounds['N']['max'],$gpoint->Lat());
                        
                    }
                   
               break;
               case 'Zend_Db_Adapter_Pgsql':
                    self::$sql = 'SELECT ST_AsGeoJson(poligon) as XY, zone FROM '.$this->table->info('name').' WHERE id_av = \''.$this->data['id_av'].'\'';
                    set_error_handler(get_class($this).'::error_handler');
                    $point = $this->table->getAdapter()->fetchRow(self::$sql);
                    restore_error_handler();
                    $jpointcoll = json_decode($point['xy']);
                    $gpoint = new \gPoint();
                    foreach($jpointcoll->coordinates[0] as $jpoint) {
                        $poligonitem = $this->appendItem();
                        
                        $gpoint->setUTM($jpoint[0], $jpoint[1],$point['zone']);
                        $gpoint->convertTMtoLL();
                        $poligonitem->setData(array(
                            'latitude'=>$gpoint->Lat(),
                            'longitude'=>$gpoint->Long(),
                        ));
                        $this->coordinates[]=array('E'=>$gpoint->Long(),'N'=>$gpoint->Lat());
                        
                        $this->bounds['E']['min'] = min ($this->bounds['E']['min'],$gpoint->Long());
                        $this->bounds['E']['max'] = max ($this->bounds['E']['max'],$gpoint->Long());
                        $this->bounds['N']['min'] = min ($this->bounds['N']['min'],$gpoint->Lat());
                        $this->bounds['N']['max'] = max ($this->bounds['N']['max'],$gpoint->Lat());
                    }
                   
               break;
            }
        }
        return $this->items;
    }
    /**
     * Returns a reduced collection of vertex
     * @return array
     */
    public function getSemplifiedVertexColl() {
        if (sizeof($this->semplified) == 0) {
            $this->getVertexColl();
            $size = ($this->bounds['E']['max']-$this->bounds['E']['min']+$this->bounds['N']['max']-$this->bounds['N']['min'])/(2*sizeof($this->coordinates));
            $rdp = RamerDouglasPeucker($this->coordinates,$size);
            foreach ($rdp as $jpoint) {
                $poligonitem = $this->appendSemplifiedItem();
                $poligonitem->setData(array(
                    'latitude'=>$jpoint['N'],
                    'longitude'=>$jpoint['E'],
                ));
            }

        }
        return $this->semplified;
    }
    /**
     * get Centroid Point
     * @return \gPoint
     */
    public function getCentroid () {
        if (!key_exists('centroid',$this->data)) {
            switch (get_class($this->table->getAdapter())) {
                case 'Zend_Db_Adapter_Mysqli':
                    self::$sql = 'SELECT X(Centroid(poligon)) as X, Y(Centroid(poligon)) as Y , zone FROM '.$this->table->info('name').' WHERE id_av = "'.$this->data['id_av'].'"';
                    $point = $this->table->getAdapter()->fetchRow(self::$sql);
                    $gpoint = new \gPoint();
                    $gpoint->setUTM($point['X'], $point['Y'], $point['zone']);
                    $gpoint->convertTMtoLL();
                    $this->data['centroid']=$gpoint;
                break;
                case 'Zend_Db_Adapter_Pgsql':
                    self::$sql = 'SELECT ST_AsGeoJson(ST_Centroid(poligon)) as XY, zone FROM '.$this->table->info('name').' WHERE id_av = \''.$this->data['id_av'].'\'';
                    set_error_handler(get_class($this).'::error_handler');
                    $point = $this->table->getAdapter()->fetchRow(self::$sql);
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
     * Return the polygon area
     * @return float
     */
    public function getArea () {
        if (!key_exists('area',$this->data)) {
            switch (get_class($this->table->getAdapter())) {
                case 'Zend_Db_Adapter_Mysqli':
                    self::$sql = 'SELECT Area(poligon) as area FROM '.$this->table->info('name').' WHERE id_av = "'.$this->data['id_av'].'"';
                    set_error_handler(get_class($this).'::error_handler');
                    $area = $this->table->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $this->data['area']=$area;
                break;
                case 'Zend_Db_Adapter_Pgsql':
                    self::$sql = 'SELECT ST_Area(poligon) as area FROM '.$this->table->info('name').' WHERE id_av = \''.$this->data['id_av'].'\'';
                    set_error_handler(get_class($this).'::error_handler');
                    $area = $this->table->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $this->data['area']=$area;
                break;

            }
        }
        return $this->data['area'];
    }
    /**
     * Return the polygon perimiter
     * @return float
     */
    public function getPerimeter () {
        if (!key_exists('perimeter',$this->data)) {
            switch (get_class($this->table->getAdapter())) {
                case 'Zend_Db_Adapter_Mysqli':
                    self::$sql = 'SELECT GLength(ExteriorRing(poligon)) as area FROM geo_particellare WHERE id_av = "'.$this->data['id_av'].'"';
                    set_error_handler(get_class($this).'::error_handler');
                    $perimeter = $this->table->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $this->data['perimeter']=$perimeter;
                break;
                case 'Zend_Db_Adapter_Pgsql':
                    self::$sql = 'SELECT ST_Perimeter(poligon) as area FROM geo_particellare WHERE id_av = \''.$this->data['id_av'].'\'';
                    set_error_handler(get_class($this).'::error_handler');
                    $perimeter = $this->table->getAdapter()->fetchOne(self::$sql);
                    restore_error_handler();
                    $this->data['perimeter']=$perimeter;
                break;

            }
        }
        return $this->data['perimeter'];
    }
}
