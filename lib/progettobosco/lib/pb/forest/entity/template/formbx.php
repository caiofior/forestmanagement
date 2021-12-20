<?php
/**
 * Manages Entity bx forest compartment
 * 
 * Manages Entity bx forest compartment
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\entity\template;
use forest\form\template\variant;

/**
 * Manages Entity bx forest compartment
 *
 * Manages Entity bx forest compartment
 *
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
interface FormBX {
     /**
     * Instantiates the table
     */
    public function __construct();
    /**
     * Loads form a data
     * @param integer $id
     */
    public function loadFromId($id);
     /**
     * Loads form a data form foreat and parcel code
     * @param string $proprieta Proprietà code
     * @param string $cod_part Forest compartment code
     */
    public function loadFromCodePart($proprieta,$cod_part);
    /**
     * Updates data
     */
    public function update() ;
    /**
     * Deletes data
     */
    public function delete();
    /**
     * Gets the associated Forest Cover Composition Collection
     * @return variant
     */
    public function getCoverCompositionColl() ;
    /**
     * Gets the associated Shrub Composition Collection
     * @return variant
     */
    public function getShrubCompositionColl();
    /**
     * Gets the associated Herbaceus Composition Collection
     * @return variant
     */
    public function getHerbaceusCompositionColl();
    /**
     * Return the associated note collection
     * @return variant
     */
    public function getNotes ();
}

