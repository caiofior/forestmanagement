<?php
/**
 * Manages Form A Description
 * 
 * Manages Form A Description
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
 * Manages Form A Description
 * 
 * Manages Form A Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
abstract class FormADescription extends \forest\mediator\FormBDescription {
     /**
     * Reference to Form a Object
     * @var \forest\entity\A
     */
    protected $a;
     /**
     * Intantiates the Description
     * @param \forest\entity\A $a
     */
    public function __construct(\forest\entity\A $a) {
        $this->a = $a;
    }
     /**
     * Generates description iterating through all private methods and ading notes
     * @return string
     */
    protected function generateDescription() {
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $method) {
            if($method->class == __CLASS__) {
                $method->setAccessible(true);
                $method->invoke($this);
            }
        }
       
        $this->t['a']['note'] = '';
        $note = $this->a->getData('note');
        if ($note != '')
            $this->t['a']['note'] = 'Note:'.$this->a->getData('note');
        
        $this->t['a'] = array_reduce($this->t['a'], create_function('$s,$i', '
            if($i != "")
                $s .= $i.", ";
            return $s;
        '));
        $this->t['a'] = ucfirst(preg_replace('/, $/', '.', $this->t['a']));
        if ($this->t['a'] != '')
            $this->t['a'] = 'Fattori ambientali e di gestione'.PHP_EOL.$this->t['a'];
        
    }
    /**
     * Phisiographic position
     */
    private function pf1() {
        $this->t['a']['pf1'] = strtolower($this->getValue('a','pf1', $this->a->getData('pf1')));
        if ($this->t['a']['pf1'] != '') $this->t['a']['pf1'] = 'posta '.$this->t['a']['pf1'].$this->getNote('a', 'pf1');
        else $this->addIssue('a', 'pf1', 'Posizione fisiografica non inserita');
    }
    /**
     * Main altitude
     */
     private function ap() {
        $this->t['a']['ap'] = $this->a->getData('ap');
        if ($this->t['a']['ap'] != '') $this->t['a']['ap'] = 'ad un\'altitudine prevalente di '.$this->t['a']['ap']. ' metri'.$this->getNote('a', 'ap');
        else $this->addIssue('a', 'pf1','Altitudine prevalente non inserita');
     }
     /**
      * Exposition
      */
     private function e1() {
                 $this->t['a']['e1'] = strtolower($this->getValue('a','e1', $this->a->getData('e1')));
        if ($this->t['a']['e1'] != '') $this->t['a']['e1'] = 'esposizione prevalente '.$this->t['a']['e1'].$this->getNote('a', 'e1');
        else $this->addIssue('a', 'e1','Esposizione prevalente non inserita');
     }
     /**
      * Main slope
      */
     private function pp () {
        $this->t['a']['pp'] = $this->a->getData('pp');
        if ($this->t['a']['pp'] != '') {
            $this->t['a']['pp'] = 'pendenza prevalente del '.$this->t['a']['pp'].' %';
            $this->t['a']['pp'] .= $this->getNote('a', 'pp');
        
        }
        else $this->addIssue('a', 'pp','Pendenza prevalente non inserita'); 
     }
     /**
      * Obstacles
      */
     private function o () {
        $this->t['a']['o'] = '';
        switch ($this->a->getData('o')) {
           case 1 :
                $this->t['a']['o'] = 'accidentalità debole'.$this->getNote('a', 'o');
           break;
           case 2 :
                $this->t['a']['o'] = 'accidentalità media'.$this->getNote('a', 'o');
           break;
           case 3:
                $this->t['a']['o'] = 'accidentalità forte'.$this->getNote('a', 'o');
           break;
           case 4:
                $this->t['a']['o'] = 'accidentalità molto forte'.$this->getNote('a', 'o');
           break;
           default:
               $this->addIssue('a', 'o','Ostacoli agli interventi non inseriti');
           break;
        }
     }
     /**
      * Terrain assets
      */
     private function a () {
        $labels = array(
               1 => 'pericolo di peggioramento della situazione di dissesto causato da',
               2 => 'alcuni contenuti problemi di dissesto legati alla presenza di',
               3 => 'grave dissesto dovuto a',
               4 => 'dissesto molto grave imputabile a'
        );
        $phrases = array(
               2 => 'erosione superficiale - incanalata',
               3 => 'erosione catastrofica - calanchiva',
               4 => 'frane superficiali',
               5 => 'frane di profondità - crolli',
               6 => 'rotolamento massi',
               7 => $this->a->getData('a8')
        );
        $this->t['a']['a'] = '';
        foreach ($phrases as $key => $phrase) {
            if (key_exists($this->a->getData('a'.$key),$labels)) {
                if (!key_exists('a'.$key, $this->t['a']))
                    $this->t['a']['a'.$key] = '';        
                $this->t['a']['a'.$key] .= $labels[$this->a->getData('a'.$key)];
                $this->t['a']['a'.$key] .= ' '.$phrase.', ';
            }
        }
        $this->t['a']['a'] .= $this->getNote('a', 'a2');
     }
     /**
      * Terrain water
      */
     private function r () {
        $labels = array(
                  1 => 'su meno del 30% della superficie',
                  2 => 'su di una superficie compresa fra il 30 e il 60% del totale',
                  3 => 'su più del 60% della superficie'
        );
        $phrases = array(
                  2 => 'terreno superficiale',
                  3 => 'rocce affioranti',
                  4 => 'pietrosità',
                  5 => 'ristagni d\'acqua'
        );
        $this->t['a']['r'] = '';
        foreach ($phrases as $key => $phrase) {
            if (key_exists($this->a->getData('r'.$key),$labels)) {
                if ($this->t['a']['r'] == '')
                    $this->t['a']['r'] = 'possibili limitazioni allo sviluppo dell\'apparato radicale per la presenza di ';
                $this->t['a']['r'] .= $phrase.' '.$labels[$this->a->getData('r'.$key)].', ';
            }
        }
        $this->t['a']['r'] = preg_replace('/, $/', '', $this->t['a']['r']);
     }
     /**
      * Phitosanitary conditions
      */
     private function f () {
        $labels = array(
            1 => 'pericolo di peggioramento della situazione fitosanitaria dovuto a',
            2 => 'danni lievi causati da',
            3 => 'danni gravi causati da',
            4 => 'danni molto gravi causati da'
        );
        $phrases = array(
           2 => 'sovrapascolamento',
           3 => 'selvatici',
           4 => 'agenti fitopatogeni e parassiti',
           5 => 'agenti meteorici',
           6 => 'movimenti di neve',
           7 => 'incendio',
           8 => 'utilizzazioni',
           9 => 'movimenti di terra',
          10 => 'attività turistico-ricreative',
          11 => $this->a->getData('f12')
        );
        $this->t['a']['f'] = '';
        foreach ($phrases as $key => $phrase) {
            if ($phrase == '') continue;
            if (key_exists($this->a->getData('f'.$key),$labels)) {
                $this->t['a']['f'] .= $labels[$this->a->getData('f'.$key)].' '.$phrase.', ';
            }
        }
        $this->t['a']['f'] = preg_replace('/, $/', '', $this->t['a']['f']);
        $this->t['a']['f'] .= $this->getNote('a', 'f2');
     }
     /**
      * Graze
      */
     private function p () {
         $phrases = array(
               2 => 'pascolo in bosco',
               3 => 'emergenze storico-naturalistiche',
               4 => 'sorgenti, fonti',
               5 => 'sottoposta a usi civici',
               6 => ''
        );
        $this->t['a']['p'] = '';
        foreach ($phrases as $key => $phrase) {
            if ($key == 2) {
                switch ($this->a->getData('p'.$key)) {
                     case 1 :
                          $this->t['a']['p'] .= $phrase.' di bovini';
                     break;
                     case 2 :
                          $this->t['a']['p'] .= $phrase.' di ovini';
                     break;
                     case 3:
                          $this->t['a']['p'] .= $phrase.' di equini';
                     break;
                     case 4:
                          $this->t['a']['p'] .= $phrase.' di caprini';
                     break;
                     case 5:
                          $this->t['a']['p'] .= $phrase.$this->a->getData('p9');
                     break;
                }
            }
            else if ($this->a->getData('p'.$key) == 1) {
                $this->t['a']['p'] .= $phrase.', ';
            }
        }
        if ($this->t['a']['p'] == '') {
            $this->t['a']['p'] = 'assenza di fatti particolari';
            $this->addIssue('a', 'p2','fatti particolari non inseriti');
        }
        else {
            $this->t['a']['p'] = 'fatti particolari: '.$this->t['a']['p'];
            $this->t['a']['p'] .= $this->getNote('a', 'p2');
        }
     }
     /**
      * Manufacts
      */
     private function m () {
          $phrases = array(
            2  => 'strade camionabili',
            3  => 'strade trattorabili',
            4  => 'piste forestali',
            5  => 'edifici',
            6  => 'sistemazioni',
            7  => 'gradonamenti',
            8  => 'muri - recinzioni',
            9  => 'paravalanghe',
            10 => 'elettrodotti',
            11 => 'cesse parafuoco',
            12 => 'tracciati teleferiche',
            13 => 'condotte idriche',
            14 => 'parcheggi',
            15 => 'cave',
            16 => 'sentieri guidati',
            17 => 'piste-impianti sciistici',
            18 => '',
            20 => 'piazzali-buche di carico',
            21 => 'strade camionabili',
            22 => 'tracciati per mezzi agricoli minori',
            23 => 'aree sosta'
        );
        $this->t['a']['m'] = '';
        foreach ($phrases as $key => $phrase) {
            if (key_exists($this->a->getData('m'.$key),$phrases)) {
                $this->t['a']['m'] .= $phrase.', ';
            }
        }
        if ($this->t['a']['m'] != '') {
            $this->t['a']['m'] = 'presenti '.$this->t['a']['m'];
            $this->t['a']['m'] .= $this->getNote('a', 'm2');
        }
        else
            $this->addIssue('a', 'm2','opere e manufatti non inseriti non inseriti');
     }
     /**
      * Temporary factors
      */
     private function c() {
         $phrases = array(
               2 => 'eccesso di pascolo',
               3 => 'eccesso di selvatici',
               4 => 'contestazioni di proprietà',
               5 => ''
        );
        $this->t['a']['c'] = '';
        foreach ($phrases as $key => $phrase) {
            if (key_exists($this->a->getData('c'.$key),$phrases)) {
                if ($key == 5)
                    $this->t['a']['c'] .= $this->a->getData('c'.$key).', ';
                else
                    $this->t['a']['c'] .= $phrase.', ';
            }
        }
        if ($this->t['a']['c'] == '') {
            $this->t['a']['c'] = 'sono assenti fattori temporaneamente condizionanti';
            $this->addIssue('a', 'c2','fattori temporaneamente non inseriti');
        }
        else {
            $this->t['a']['c'] = 'è temporaneamente condizionante la presenza di '.$this->t['a']['c'];
            $this->t['a']['c'] .= $this->getNote('a', 'c2');
        }
     }
     /**
      * Viability
      */
     private function v () {
        $this->t['a']['v']='';
        if ($this->a->getData('v1') != '') {
            $this->t['a']['v']='accessibilità buona sul '.$this->a->getData('v1').' % della particella';
        }
        if ($this->a->getData('v3') != '') {
            if ($this->t['a']['v']=='')
                $this->t['a']['v']='accesibilità ';
            $this->t['a']['v']='accessibilità insufficiente sul '.$this->a->getData('v3').' % della particella';
        }
        if ($this->t['a']['v'] == '')
            $this->t['a']['v'] .= $this->getNote('a', 'v1');
        else
             $this->addIssue('a', 'v1','Viabilità non inserita');
        

     }
     /**
      * Improductives
      */
     private function i () {
        $phrases = array (
                  3 => 'rocce',
                  4 => 'acque',
                  5 => 'strade',
                  6 => 'viali tagliafuoco',
                  7 => ''
        );
        $this->t['a']['i'] = '';
        foreach ($phrases as $key => $phrase) {
            if (key_exists($this->a->getData('i'.$key),$phrases)) {
                if ($key == 7)
                    $this->t['a']['i'] .= $this->a->getData('i'.$key).', ';
                else
                    $this->t['a']['i'] .= $phrase.', ';
            }
        }
        if ( $this->t['a']['i'] != '') {
            if ($this->a->getData('i1') >0)
                $this->t['a']['i'] =  'improduttivi '.$this->a->getData('i1').' ha circa per la presenza di '.$this->t['a']['i'].$this->getNote('a', 'i2');
            else if ($this->a->getData('i2') >0) 
                $this->t['a']['i'] =  'improduttivo '.$this->a->getData('i2').' % circa della superficie per la presenza di '.$this->t['a']['i'].$this->getNote('a', 'i2');
        }
        else
            $this->addIssue('a', 'i2','Improduttivi non inseriti');
        
        $this->t['a']['i22'] = '';
        if ($this->a->getData('i21') >0)
            $this->t['a']['i22'] =  'produttivi non boscati '.$this->a->getData('i21').' ha circa'.$this->getNote('a', 'i22');
        else if ($this->a->getData('i22') >0) 
            $this->t['a']['i22'] =  'produttivi non boscati '.$this->a->getData('i22').' % circa della superficie'.$this->getNote('a', 'i22');
        else
            $this->addIssue('a', 'i22','Improduttivi non inseriti');
     }

}