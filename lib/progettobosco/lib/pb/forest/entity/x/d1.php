<?php
/**
 * Manages Entity D1 forest compartment
 * 
 * Manages Entity D1 forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\x;
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
 * Manages Entity D1 forest compartment
 * 
 * Manages Entity D1 forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class D1 extends \forest\template\Entity {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('sched_d1');
    }
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        $this->calculatedVariables();
    }
        
} 