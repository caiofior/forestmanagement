<?php
/**
 * Manages Viability Intervent attribute
 * 
 * Manages Viability Intervent attribute
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
 * Manages Viability Intervent attribute
 * 
 * Manages Viability Intervent attribute
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ViabilityIntervent extends \Content implements \forest\template\Attribute {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('int_via');
    }
    }
