<?php
/**
 * Manages Geographic Polygon Item
 * 
 * Manages Geographic Polygon Item
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\geo;
if (!class_exists('Content')) {
    $file = 'geo'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Geographic Polygon Item
 * 
 * Manages Geographic Polygon Item
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class PolygonItem  extends \Content {
    /**
     * Sets the data and checks invalid data
     * @param variant $data
     * @param string|null $field
     * @throws \Exception
     */
    public function setData($data, $field = null) {
        if (is_array($data)) {
            if (key_exists('latitude', $data) &&
                ($data['latitude'] < -90 || $data['latitude'] > 90 )
               )
                   throw new \Exception('Latitude not valid ',1605131048);
            if (key_exists('longitude', $data) &&
                ($data['longitude'] < -180 || $data['longitude'] > 180 )
               )
                   throw new \Exception('Longitude not valid ',1605131049);
            
        }
        parent::setData($data, $field);
    }
}
