<?php
/**
 * Manages Entity A forest compartment
 * 
 * Manages Entity A forest compartment
 * 
 * @link https://it.wikipedia.org/wiki/Particella_assestamentale
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
 * Manages Entity A forest compartment
 * 
 * Manages Entity A forest compartment
 * 
 * @link https://it.wikipedia.org/wiki/Particella_assestamentale
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class A extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('schede_a');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        $this->calculatedVariables();
    }
    /**
     * Loads form a data form foreat and parcel code
     * @param string $proprieta Proprietà code
     * @param string $cod_part Forest compartment code
     */
    public function loadFromCodePart($proprieta,$cod_part) {
        $where = $this->table->getAdapter()->quoteInto('proprieta = ?', $proprieta).' AND ';
        $where .= $this->table->getAdapter()->quoteInto('cod_part = ?', $cod_part);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the cod part',1302081202);
        $this->data = $data->toArray();
        $this->calculatedVariables();
    }

    /**
     * Return the forest associate with a form
     * @return \forest\Forest
     */
    public function getForest() {
        $bosco = new \forest\Forest();
        $bosco->loadFromCode($this->data['proprieta']);
        return $bosco;
    }
    /**
     * Sets the calculated variables
     */
    private function calculatedVariables () {
        $this->rawData['descrizione'] = '';
        if (
                key_exists('proprieta', $this->data) &&
                key_exists('cod_part', $this->data)
                ) {
            $partcomp = new \Zend_Db_Table('partcomp');
            $select = $partcomp->select()->from('partcomp','abstract')->where('proprieta = ?', $this->data['proprieta'])->where('cod_part = ?', $this->data['cod_part']);
            $this->rawData['descrizione'] = $partcomp->getAdapter()->fetchOne($select);
        }
        /**
         * calcolo improduttivi
         */
        $this->rawData['improduttivi_calcolo']=0;
        if ($this->data['i1'] > 0 )
            $this->rawData['improduttivi_calcolo']=$this->data['i1'];
        else if ($this->data['i2'] > 0 )
            $this->rawData['improduttivi_calcolo']=$this->data['sup_tot']*$this->data['i2']/100;
        /**
         * calcolo produttivi non boscati
         */
        $this->rawData['prod_non_bosc_calcolo']=0;
        if ($this->data['i21'] > 0 )
            $this->rawData['prod_non_bosc_calcolo']=$this->data['i21'];
        else if ($this->data['i22'] > 0 )
            $this->rawData['prod_non_bosc_calcolo']=$this->data['sup_tot']*$this->data['i22']/100;
        /**
         * calcolo superficie boscata
         */
        $this->rawData['boscata_calcolo']=$this->data['sup_tot']-$this->rawData['improduttivi_calcolo']-$this->rawData['prod_non_bosc_calcolo'];
    }
    /**
     * Gets the associated municipality
     * @return \forest\attribute\Municipality
     */
    public function getMunicipality () {
        $municipality = new \forest\attribute\Municipality();
        $municipality->loadFromCode($this->data['comune']);
        return $municipality;
    }
    /**
     * Gets the associated collector
     * @return \forest\attribute\Collector
     */
    public function getCollector() {
        $collector = new \forest\attribute\Collector();
        $collector->loadFromId($this->data['codiope']);
        return $collector;
    }
    /**
     * Return the associated note collection
     * @return \forest\attribute\note\AColl
     */
    public function getNotes () {
        $notes = new \forest\attribute\note\AColl();
        $notes->setForm($this);
        return $notes;
    }
    /**
     * Return a collection of cadastral parcel associated with the forest parcel
     * @return \forest\attribute\CadastralColl
     */
    public function getCadastalColl () {
        $cadastralcoll = new \forest\attribute\CadastralColl();
        $cadastralcoll->setForm($this);
        return $cadastralcoll;
    }
    /**
     * Return the associated B Collection
     * @return \forest\entity\b\BColl
     */
    public function getBColl () {
        $bcoll = new \forest\entity\b\BColl();
        $bcoll->setFormA($this);
        $bcoll->loadAll();
        return $bcoll;
    }
    /**
     * Gets available b forms for a fores compartment
     * @return array
     */
    public function getBForms() {
        $bcoll = $this->getBColl();
        if ($bcoll->countAll() == 0)
            return array(
                'b1',
                'b2',
                'b3',
                'b4'
            );
        $tabs = array();
        $b = $bcoll->getFirst();
        if ($b->getB1Coll()->countAll() > 0)
            $tabs[]='b1';
        if ($b->getB2Coll()->countAll() > 0)
            $tabs[]='b2';
        if ($b->getB3Coll()->countAll() > 0)
            $tabs[]='b3';
        if ($b->getB4Coll()->countAll() > 0)
            $tabs[]='b4';
        switch ($b->getData('u')) {
            case 0:
            case '':
            break;
            case 1:
                $tabs[]='b1';
            break;
            case 2:
            case 10:
            case 11:
            case 12:
                $tabs[]='b2';
            break;
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
            case 9:
                $tabs[]='b3';
            break;
            case 13:
                $tabs[]='b4';
            break;
            default:
                $tabs= array(
                'b1',
                'b2',
                'b3',
                'b4'
            );
            break;
        }
        return array_unique($tabs);
    }
    /**
     * Gets the associated poligon
     * @return \forest\geo\Polygon
     */
    public function getPoligon() {
        $poligon = new \forest\geo\Polygon('geo_particellare');
        $poligon->loadFromId($this->data['id_av']);
        return $poligon;
    }
    /**
     * Generates forest compartment description
     * @return string
     */
    public function generateDescription () {
        $adesc = new \forest\mediator\ForestCompartmentDescription($this);
        $description = $adesc->generateDescription();;
        return $description;
    }

} 
