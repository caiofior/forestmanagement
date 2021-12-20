<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
?>

<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/descrizione.css";
</script>
<div id="tabContent">
<form id="formDescrizione" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=descrizione&id=<?php echo $a->getData('objectid');?>">
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $a->getData('proprieta');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $a->getData('objectid');?>"/>
        <div id="descrizione_container">
            <label for="descrizione">Descrizione</label>
            <textarea cols="60" rows="30" id="descrizione" name="descrizione" ><?php echo $a->getRawData('descrizione');?></textarea>
            <a id="recreate_description" href="#">Rigenera descrizione</a>
        </div>
        </fieldset>
</form>
<script type="text/javascript" src="js/descrizione.js" defer="defer"></script>
</div>
</div>