<?php 
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * KML page controller
 */
header('Content-type: application/vnd.google-earth.kml+xml');
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
echo '<?xml version="1.0" encoding="utf-8" ?>'.PHP_EOL; ?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document>
<Style id="myDefaultPoligon">
<LineStyle>
      <color>ff0000ff</color>
</LineStyle>
<PolyStyle>
      <fill>0</fill>
</PolyStyle>
</Style>
<?php 
if (key_exists('id_av', $_REQUEST)) :
$poligon = new \forest\geo\Polygon($_REQUEST['table']);
$poligon->loadFromId($_REQUEST['id_av']); ?>
<Placemark id="<?php echo $poligon->getData('id_av');?>">
        <name><?php echo $poligon->getData('id_av');?></name>
        <description><?php echo $poligon->getData('id_av');?></description>
	<styleUrl>#myDefaultPoligon</styleUrl>
        <Polygon><tessellate>1</tessellate><outerBoundaryIs><LinearRing><coordinates><?php
foreach($poligon->getSemplifiedVertexColl() as $key=>$poligonitem) {
  if ($key!= 0) echo ' ';
  echo $poligonitem->getRawData('longitude').','.$poligonitem->getRawData('latitude').',0';
}?></coordinates></LinearRing></outerBoundaryIs></Polygon>
</Placemark>
<?php elseif (key_exists('forest_id', $_REQUEST)) : 
$forest = new \forest\Forest();
$forest->loadFromCode($_REQUEST['forest_id']);
?>
<?php 
$poligoncoll = $forest->getPoligonColl();
$poligoncoll->loadAll();
foreach($poligoncoll->getItems() as $poligon) : 
$centroid = $poligon->getCentroid();?>
<Placemark id="<?php echo $poligon->getData('id_av');?>">
        <styleUrl>#myDefaultPoligon</styleUrl>
      <Polygon><tessellate>1</tessellate><outerBoundaryIs><LinearRing><coordinates><?php
foreach($poligon->getSemplifiedVertexColl() as $key=>$poligonitem) {
  if ($key!= 0) echo ' ';
  echo $poligonitem->getRawData('longitude').','.$poligonitem->getRawData('latitude').',0';
}?></coordinates></LinearRing></outerBoundaryIs></Polygon>
</Placemark>
<Placemark id="<?php echo $poligon->getData('id_av');?>centroid">
<name>Particella <?php echo $poligon->getData('id_av');?></name>
<Point><coordinates><?php echo $centroid->Long();?>,<?php echo $centroid->Lat();?>,0</coordinates></Point>
</Placemark>
<?php endforeach; ?>
<?php endif;?>
</Document>
</kml>