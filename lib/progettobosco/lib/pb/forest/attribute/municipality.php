<?php
/**
 * Manages Municipality attribute
 * 
 * Manages Municipality attribute
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
 * Manages Municipality attribute
 * 
 * Manages Municipality attribute
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Municipality extends \Content implements \forest\template\Attribute {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('comuni');
    }
    /**
     * Load data from code
     * @param string $code Municipality code
     */
    public function loadFromCode($code) {
        if ($code == '')
            return;
        $where = $this->table->getAdapter()->quoteInto('codice = ?', $code);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the municpality',3001251405);
        $this->data = $data->toArray();
        $this->calculatedVariables();
    }
    /**
     * Sets the calculated values
     */
    private function calculatedVariables () {
        $province = new \forest\attribute\Province();
        $province->loadFromCode($this->data['provincia']);
        $this->rawData['province_code']=$province->getData('sigla');
    }
}
