<?php
/**
 * Manages Forest compartment Collection
 * 
 * Manages Forest compartment Collection
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
 * Manages Forest compartment Collection
 * 
 * Manages Forest compartment Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
abstract class EntityColl extends \ContentColl {
    
}