<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b1 = $b->getB1Coll()->getFirst();
$x = $b1->getXColl()->getFirst();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/rilievidendrometrici.css";
</script>
        <div id="tabContent">
    <form id="formXList" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formx&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formx_errors" style="display: none;"></div>
        <fieldset id="selector">
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        <div id="tipo_ril_container">
            <label for="tipo_ril">Tipo di rilevo</label>
            <select id="tipo_ril" name="tipo_ril">
                <option value="">Scegli un tipo di rilievo</option>
                <?php
                $relivetypecoll = new \forest\attribute\ReliveTypeColl();
                $relivetypecoll->loadAll();
                foreach($relivetypecoll->getItems() as $relivetype) : ?>
                <option value="<?php echo $relivetype->getData('codice'); ?>"><?php echo $relivetype->getData('descrizion'); ?></option>
                <?php endforeach;?>
            </select>
        </div>
        </fieldset>
        <?php require __DIR__.DIRECTORY_SEPARATOR.'rilievidendrometrici'.DIRECTORY_SEPARATOR.'list.php';?>
    </form>
    <script type="text/javascript" src="js/rilievidendrometrici.js" defer="defer"></script>
</div>
</div>