<?php
/**
 * Manages Table attribute
 * 
 * Manages Table attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Table attribute
 * 
 * Manages Table attribute
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Table  extends \Content {
    /**
     * Reference of specific table types
     * @var array
     */
    private $tables;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('diz_tavole');
        $this->tables=array(
            'table2coll' => null,
            'table4' =>new \forest\attribute\table\Table4(),
            'table5' =>new \forest\attribute\table\Table5()
        );
    }
    /**
     * Redifines load data with specific types
     * @param int $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        if ($this->data['biomassa'] == 't') {
            $this->tables['table4']->loadFromId($this->data['codice']);
            $this->tables['table5']->loadFromId($this->data['codice']);
        }
        if ($this->data['forma'] == 1) {
            $this->tables['table2coll'] = new \forest\attribute\table\Table2Coll();
            $this->tables['table2coll']->setTable($this);
        }
    }
    /**
     * Return Table4 object
     * @return  \forest\attribute\table\Table4
     */
    public function getTable4() {
        return $this->tables['table4'];
    }
    /**
     * Return Table5 object
     * @return  \forest\attribute\table\Table5
     */
    public function getTable5() {
        return $this->tables['table5'];
    }
    /**
     * Returns a Table2Coll
     * @return \forest\attribute\table\Table2Coll
     */
    public function getTable2Coll() {
        return $this->tables['table2coll'];
    }
}
