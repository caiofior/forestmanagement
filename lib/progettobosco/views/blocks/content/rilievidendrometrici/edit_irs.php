<?php
$fcoll = $x->getFColl();
$fcoll->loadAll();
if($fcoll->count() == 0)
    $f = $fcoll->addItem();
else
    $f = $fcoll->getFirst();
?>
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/irs.css";
</script>
<fieldset>
<p >Scheda F per il rilievo dendrometrico IRS</p>
<div id="data_container">
    <label for="data">Data</label>
    <input id="data" name="data" value="<?php echo $x->getData('data');?>">
</div>
<div id="n_camp_container">
    <label for="n_camp">N° unità campionaria</label>
    <input id="n_camp" name="n_camp" value="<?php echo $f->getData('n_camp');?>">
</div>
<div id="codiope_container">
    <label for="codiope">Rilevatore</label>
    <input type="hidden" id="codiope" name="codiope" value="<?php echo $f->getData('codiope');?>"/>
    <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $f->getCollector()->getData('descriz');?>"/>
</div>
<div id="f_container">
    <label for="f">Fattore di numerazione</label>
    <input id="f" name="f" value="<?php echo $f->getData('f');?>">
</div>
<div id="d_ogni_container">
    <label for="d_ogni">È stato misurato un diametro ogni:</label>
    <input id="d_ogni" name="d_ogni" value="<?php echo $f->getData('d_ogni');?>">
</div>
<div id="h_ogni_container">
    <label for="h_ogni">È stata misurata un'altezza ogni:</label>
    <input id="h_ogni" name="h_ogni" value="<?php echo $f->getData('h_ogni');?>">
</div>
<div id="y_container">
    <label for="y">Y</label>
    <input id="y" name="y" value="<?php echo $f->getData('y');?>">
</div>
<div id="x_container">
    <label for="x">X</label>
    <input id="x" name="x" value="<?php echo $f->getData('x');?>">
</div>

<fieldset id="irs1_table_container" >
    <div >
            <div>
                <span>
                    <div>Specie</div>
                </span>
                <span>
                    <div>n° alberi contati</div>
                </span>
                <span>
                    <div>n° alberi da prelevare</div>
                </span>
                <span>
                    <div>Azioni</div>
                </span>
            </div>
        <div>
        <span>
            <div>
            <input type="hidden" id="specie" name="specie" value=""/>
            <input id="specie_descr" name="specie_descr" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="n_cont" name="n_cont" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="n_prel" name="n_prel" value=""/>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formc1&amp;action=editarbustive&amp;id=<?php echo $f->getData('objectid');?>" data-update="content_rilievidendrometrici_irs1">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
            </a>
            </div>
        </span>
        </div>
    </div>
    <?php require (__DIR__.DIRECTORY_SEPARATOR.'listirs1.php');?>
</fieldset>
<fieldset id="irs2_table_container" >
    <div >
            <div>
                <span>
                    <div>Specie</div>
                </span>
                <span>
                    <div>D</div>
                </span>
                <span>
                    <div>H</div>
                </span>
                <span>
                    <div>Azioni</div>
                </span>
            </div>
        <div>
        <span>
            <div>
            <input type="hidden" id="specie2" name="specie2" value=""/>
            <input id="specie2_descr" name="specie2_descr" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="d2" name="d2" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="h2" name="h2" value=""/>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formc2&amp;action=editarbustive&amp;id=<?php echo $f->getData('objectid');?>" data-update="content_rilievidendrometrici_irs2">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
            </a>
            </div>
        </span>
        </div>
    </div>
    <?php require (__DIR__.DIRECTORY_SEPARATOR.'listirs2.php');?>
</fieldset>
<div id="note_container">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="5" cols="15"><?php echo $f->getData('note');?></textarea>
</div>
</fieldset>
<script type="text/javascript" src="js/irs.js" defer="defer"></script>