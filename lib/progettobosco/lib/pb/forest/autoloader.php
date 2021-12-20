<?php
/**
 * Autoloading forest files
 * 
 * Autoloading forest files
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest;
if (!class_exists('Autoloader')) {
   if (!class_exists('\\Autoloader'))
        require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'autoloader.php';
   /**
    * Module configuration class
    */
   class Autoloader extends \StdClass {
       /**
        * Module base directory
        * @var string
        */
       public $dir = __DIR__;
       /**
        * Module required files
        * @var array
        */
       public $files = array();
       /**
        * Sets module required file
        */
       public function __construct() {
           $this->files = array(
        'template'.DIRECTORY_SEPARATOR.'entity.php',
        'template'.DIRECTORY_SEPARATOR.'entitycoll.php',
        'template'.DIRECTORY_SEPARATOR.'control.php',
        'template'.DIRECTORY_SEPARATOR.'controlcoll.php',
        'template'.DIRECTORY_SEPARATOR.'archivicoll.php',
        'template'.DIRECTORY_SEPARATOR.'attribute.php',
        'template'.DIRECTORY_SEPARATOR.'attributecoll.php',
        
        'forest.php',
        'forestcoll.php',
        'workingcircle.php',
        'workingcirclecoll.php',
        'region.php',
        'regioncoll.php',
        
        'entity'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'formbx.php',
        'entity'.DIRECTORY_SEPARATOR.'a.php',
        'entity'.DIRECTORY_SEPARATOR.'acoll.php',
        'entity'.DIRECTORY_SEPARATOR.'n.php',
        'entity'.DIRECTORY_SEPARATOR.'ncoll.php',
        
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'bcoll.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b1.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b1coll.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b2.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b2coll.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b3.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b3coll.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b4.php',
        'entity'.DIRECTORY_SEPARATOR.'b'.DIRECTORY_SEPARATOR.'b4coll.php',

        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'x.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'xcoll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'d.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'dcoll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'d1.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'d1coll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'c.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'ccoll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'c1.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'c1coll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'c2.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'c2coll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'f.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'fcoll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'f1.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'f1coll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'f2.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'f2coll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'g1.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'g1coll.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'g.php',
        'entity'.DIRECTORY_SEPARATOR.'x'.DIRECTORY_SEPARATOR.'gcoll.php',
        
        'entity'.DIRECTORY_SEPARATOR.'e'.DIRECTORY_SEPARATOR.'e.php',
        'entity'.DIRECTORY_SEPARATOR.'e'.DIRECTORY_SEPARATOR.'ecoll.php',
        'entity'.DIRECTORY_SEPARATOR.'e'.DIRECTORY_SEPARATOR.'e1.php',
        'entity'.DIRECTORY_SEPARATOR.'e'.DIRECTORY_SEPARATOR.'e1coll.php',
        
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu1_3.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu1_3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu2_3.php',
        'attribute'.DIRECTORY_SEPARATOR.'template'.DIRECTORY_SEPARATOR.'piu2_3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'soiluse.php',
        'attribute'.DIRECTORY_SEPARATOR.'soilusecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'collector.php',
        'attribute'.DIRECTORY_SEPARATOR.'collectorcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'municipality.php',
        'attribute'.DIRECTORY_SEPARATOR.'municipalitycoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'province.php',
        'attribute'.DIRECTORY_SEPARATOR.'provincecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'a.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'acoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'bcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b2.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b2coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b3.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b4.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'b4coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'n.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'ncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'template.php',
        'attribute'.DIRECTORY_SEPARATOR.'note'.DIRECTORY_SEPARATOR.'templatecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'cadastral.php',
        'attribute'.DIRECTORY_SEPARATOR.'cadastralcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'foresttype.php',
        'attribute'.DIRECTORY_SEPARATOR.'foresttypecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'structure.php',
        'attribute'.DIRECTORY_SEPARATOR.'structurecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b1.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b1coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b2.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b2coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b3.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b4.php',
        'attribute'.DIRECTORY_SEPARATOR.'covercomposition'.DIRECTORY_SEPARATOR.'b4coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b1.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b1coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b2.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b2coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b3.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b4.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceuscomposition'.DIRECTORY_SEPARATOR.'b4coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b1.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b1coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b2.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b2coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b3.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b3coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b4.php',
        'attribute'.DIRECTORY_SEPARATOR.'shrubcomposition'.DIRECTORY_SEPARATOR.'b4coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'b3renovationcomposition.php',
        'attribute'.DIRECTORY_SEPARATOR.'b3renovationcompositioncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'b3treelinecomposition.php',
        'attribute'.DIRECTORY_SEPARATOR.'b3treelinecompositioncoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'arboreal.php',
        'attribute'.DIRECTORY_SEPARATOR.'arborealcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbacea.php',
        'attribute'.DIRECTORY_SEPARATOR.'herbaceacoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'forestmassesteem.php',
        'attribute'.DIRECTORY_SEPARATOR.'forestmassesteemcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'pastureweed.php',
        'attribute'.DIRECTORY_SEPARATOR.'pastureweedcoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'tabletype.php',
        'attribute'.DIRECTORY_SEPARATOR.'tabletypecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'table.php',
        'attribute'.DIRECTORY_SEPARATOR.'tablecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'table2.php',
        'attribute'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'table2coll.php',
        'attribute'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'table4.php',
        'attribute'.DIRECTORY_SEPARATOR.'table'.DIRECTORY_SEPARATOR.'table5.php',
        'attribute'.DIRECTORY_SEPARATOR.'relivetype.php',
        'attribute'.DIRECTORY_SEPARATOR.'relivetypecoll.php',
        'attribute'.DIRECTORY_SEPARATOR.'viabilityintervent.php',
        'attribute'.DIRECTORY_SEPARATOR.'viabilityinterventcoll.php',
        
        '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'gPoint'.DIRECTORY_SEPARATOR.'gPoint.php',
        '..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'rdp'.DIRECTORY_SEPARATOR.'rdp.php',
        'geo'.DIRECTORY_SEPARATOR.'polygon.php',
        'geo'.DIRECTORY_SEPARATOR.'polygonitem.php',
        'geo'.DIRECTORY_SEPARATOR.'polygoncoll.php',
        
        'mediator'.DIRECTORY_SEPARATOR.'description.php',
        'mediator'.DIRECTORY_SEPARATOR.'formb1description.php',
        'mediator'.DIRECTORY_SEPARATOR.'formbdescription.php',
        'mediator'.DIRECTORY_SEPARATOR.'formadescription.php',
        'mediator'.DIRECTORY_SEPARATOR.'forestcompartmentdescription.php'
        );
        }
   }
   $class = new Autoloader();
   \AutoLoader::loadRequiredFiles($class);
}
