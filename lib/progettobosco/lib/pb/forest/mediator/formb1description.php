<?php
/**
 * Manages Form B1 Description
 * 
 * Manages Form B1 Description
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
 * Manages Form B1 Description
 * 
 * Manages Form B1 Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class FormB1Description extends \forest\mediator\Description {
    /**
     * Refrerence to B1 entity
     * @var \forest\entity\b\B1
     */
    protected $b1;
    /**
     * Generates description iterating through all private methods and ading notes
     * @return string
     */
    protected function generateDescription() {
        $this->b1 = $this->b->getB1Coll ()->getFirst();
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $method) {
            if($method->class == __CLASS__) {
                $method->setAccessible(true);
                $method->invoke($this);
            }
        }
        $this->t['b1']['note'] = '';
        $note = $this->b1->getData('note');
        if ($note != '')
            $this->t['b1']['note'] = 'Note:'.$this->b1->getData('note');
        
        $this->t['b1'] = array_reduce($this->t['b1'], create_function('$s,$i', '
            if($i != "")
                $s .= $i.", ";
            return $s;
        '));
        $this->t['b1'] = ucfirst(preg_replace('/, $/', '.', $this->t['b1']));
        if ($this->t['b1'] != '')
            $this->t['b1'] = 'Descrizione fisionomico-colturale'.PHP_EOL.$this->t['b1'];
        
    }
    /**
     * Creates cover composition description
     * @return null
     */
    private function coverComposition () {
        $this->t['b1']['spe_arbq']='';
        $cod_coper = array(
            1=>'',
            2=>'',
            3=>'',
            4=>''
        );
        $covercomposition = $this->b1->getCoverCompositionColl();
        $covercomposition->loadAll();
        foreach($covercomposition->getItems() as $coveritem) {
            if (!key_exists($coveritem->getData('cod_coper'), $cod_coper)) {
                $this->addIssue('b1', 'spe_arbq','Percentuale specie arboree non inserita');
                continue;
            }
            if ($cod_coper[$coveritem->getData('cod_coper')] != '')
                $cod_coper[$coveritem->getData('cod_coper')] .= ', ';
            $cod_coper[$coveritem->getData('cod_coper')] .= $coveritem->getRawData('cod_colt_nome_per_trad');
        }
        $cod_coper = array_filter($cod_coper);
        if (sizeof($cod_coper) == 0) {
            $this->addIssue('b1', 'spe_arbq','Specie arboree non inserite');
            return;
        }
        if (key_exists(4, $cod_coper)) {
            if ($cod_coper[3] != '') $cod_coper[3] .= ', ';
                $cod_coper[3] .= $cod_coper[4];
        }

        $this->t['b1']['spe_arbq'].=$cod_coper[1];
        if (key_exists(2, $cod_coper))
            $this->t['b1']['spe_arbq'].= ' e '.$cod_coper[2];
        if (key_exists(3, $cod_coper))
            $this->t['b1']['spe_arbq'].= ' e in subordine '.$cod_coper[3];
        $this->t['b1']['spe_arbq'] .= $this->getNote('b1', 'spe_arbo');
        
    }
    /**
     * Density description
     */
    private function d() {
        if ($this->b1->getData('g') <> 10) {
            $phrases = array(
               1 => 'densità insufficiente',
               2 => 'densità scarsa',
               3 => 'densità adeguata',
               4 => 'densità eccessiva'
            );
            if (key_exists($this->b1->getData('d'), $phrases)) 
                $this->t['b1']['d'] = $phrases[$this->b1->getData('d')].$this->t['b1']['spe_arbq'].$this->getNote('b1', 'd');
            else
                $this->addIssue('b1', 'd','Densità non inserita');
       }
    }
     /**
     * Cover grade
     */
    private function ce() {
        if ($this->b1->getData('ce') != '') 
            $this->t['b1']['ce'] = 'grado di copertura pari a '.$this->b1->getData('ce').$this->getNote('b1', 'ce');
        else
            $this->addIssue('b1', 'ce','Grado di copertura non inserita');

    }
}