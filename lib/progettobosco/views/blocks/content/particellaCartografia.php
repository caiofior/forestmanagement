<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
try{
$poligon = $a->getPoligon();
} catch (Exception $e) {
    if($e->getCode() == 1217230513)
        $poligon = false;
}
if (
        isset ($poligon) && 
        is_object($poligon) &&
        $poligon !== false) :
$centroid = $poligon->getCentroid();
?>
<script type="text/javascript">
    var center = {
    lat : <?php echo $centroid->Lat();?>,
    long : <?php echo $centroid->Long();?>,
    id_av : "<?php echo $GLOBALS['BASE_URL'].'kml.php?table=geo_particellare&id_av='.$poligon->getData('id_av'); ?>"
    };
</script>
<?php endif; ?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/cartografia.css";
</script>
<div id="tabContent">
<div id="map-canvas"></div>
<script type="text/javascript" src="js/cartografia.js" defer="defer"></script>
</div>
</div>