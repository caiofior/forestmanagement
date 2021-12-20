<?php
/**
 * Manages Form B Description
 * 
 * Manages Form B Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\mediator;


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
 * Manages Form B Description
 * 
 * Manages Form B Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class FormBDescription extends \forest\mediator\FormB1Description {
    /**
     * Refrerence to B entity
     * @var \forest\entity\b\B
     */
    protected $b;
    /**
     * Generates description iterating through all private methods and ading notes
     * @return string
     */
    protected function generateDescription() {
        $this->b = $this->a->getBColl ()->getFirst();
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $method) {
            if($method->class == __CLASS__) {
                $method->setAccessible(true);
                $method->invoke($this);
            }
        }
        if ($this->b->getData('u') == 1) {
            \forest\mediator\FormB1Description::generateDescription();
        }
        $this->t['b']='';
        if (key_exists('b1', $this->t))
            $this->t['b'].=$this->t['b1'];
    }
}