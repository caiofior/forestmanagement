<?php
/**
 * Manages Forest Control Collection
 * 
 * Manages Forest Control Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\template;
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Forest Control Collection
 * 
 * Manages Forest Control Collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
interface AttributeColl {
    /**
     * Set forest filter
     * @param \forest\Forest $forest
     */
    public function setForest (\forest\Forest $forest);
}