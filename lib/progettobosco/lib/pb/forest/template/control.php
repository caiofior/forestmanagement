<?php 
/**
 * Manages Entity control forest compartment
 * 
 * Manages Entity control forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\template;

if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Entity control forest compartment
 * 
 * Manages Entity control forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Control extends \Content {
    /**
     * Instantiate the table by string name
     * @param type $table
     */
    public function __construct($table = null) {
        parent::__construct($table);
    }
    /**
     * Fized different field names
     * @param string $field
     */
    public function getData($field = null) {
        $data=parent::getData($field);
        if ($field == 'descriz' && $data == '')
            $data=parent::getData('valore');
        if ($field == 'descriz' && $data == '')
            $data=parent::getData('descrizion');
        return $data;
    }
}