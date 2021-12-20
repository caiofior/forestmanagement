<?php
/**
 * Manages Forest Compartment Description
 * 
 * Manages Forest Compartment Description
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
 * Manages Forest Compartment Description
 * 
 * Manages Forest Compartment Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ForestCompartmentDescription extends \forest\mediator\FormADescription {
    /**
     * Issues during description elaboration
     * @var array
     */
    protected $issues=array();
    /**
     * Text lines composing the description
     * @var array
     */
    protected $t=array();

    /**
     * Generates description
     * @return string
     */
    public function generateDescription() {
        $description = '';
        if (!$this->a instanceof \forest\entity\A )
            return $description;
        
        \forest\mediator\FormADescription::generateDescription();
        \forest\mediator\FormBDescription::generateDescription();
        
        $description .= <<<EOT
Particella {$this->a->getData('proprieta')} {$this->a->getData('toponimo')} {$this->a->getData('sup_tot')} ha
{$this->t['a']}
{$this->t['b']}
EOT;
                
        
        return $description;
    }

 }