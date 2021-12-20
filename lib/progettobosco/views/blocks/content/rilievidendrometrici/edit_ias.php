<?php
$dcoll = $x->getDColl();
$dcoll->loadAll();
if($dcoll->count() == 0)
    $d = $dcoll->addItem();
else
    $d = $dcoll->getFirst();
?>
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/ias.css";
</script>
<fieldset>
<div id="data_container">
    <label for="data">Data</label>
    <input readonly="readonly" id="data" name="data" value="<?php echo $x->getData('data');?>">
</div>
<p >Scheda D per il rilievo dendrometrico IAS</p>
<div id="n_camp_container">
    <label for="n_camp">N° Unità campionamento</label>
    <input id="n_camp" name="n_camp" value="<?php echo $d->getData('n_camp');?>">
</div>
<div id="codiope_container">
    <label for="codiope">Rilevatore</label>
    <input type="hidden" id="codiope" name="codiope" value="<?php echo $d->getData('codiope');?>"/>
    <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $d->getCollector()->getData('descriz');?>"/>
</div>
<div id="p_container">
    <label for="p">Pendenza</label>
    <input id="p" name="p" value="<?php echo $d->getData('p');?>">
</div>
<div id="x_container">
    <label for="x">X</label>
    <input id="x" name="x" value="<?php echo $d->getData('x');?>">
</div>
<div id="y_container">
    <label for="y">Y</label>
    <input id="y" name="y" value="<?php echo $d->getData('y');?>">
</div>
<div id="f_container">
    <label for="f">Fattore di numerazione relascopica</label>
    <input id="f" name="f" value="<?php echo $d->getData('f');?>">
</div>
<p id="note_ird1">Metodo di misurazione dell' incremento</p>
<p id="note_ird2">Conteggio del numero degli anelli contenuti negli ultimi</p>
<p id="note_ird3">misurazione in mm dello spessore delle ultime</p>
<div id="c_anel_container">
    <label for="c_anel">mm di raggio</label>
    <input id="c_anel" name="c_anel" value="<?php echo $d->getData('c_anel');?>">
</div>
<div id="m_anel_container">
    <label for="m_anel">cerchie annuali</label>
    <input id="m_anel" name="m_anel" value="<?php echo $d->getData('m_anel');?>">
</div>
<div id="note_container">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="5" cols="15"><?php echo $d->getData('note');?></textarea>
</div>
<fieldset id="ird_table_container" >
    <legend><span>Composizione strato arboreo - arbustiva</span></legend>
    <div id="new_ird">
            <div>
                <span>
                    <div>Specie</div>
                </span>
                <span>
                    <div>Diametro</div>
                </span>
                <span>
                    <div>Frequenza</div>
                </span>
                <span>
                    <div>Altezza</div>
                </span>
                <span>
                    <div>Increm</div>
                </span>
                <span>
                    <div>Frequenza prelievo</div>
                </span>
                <span>
                    <div>Forma</div>
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
            <input id="diam" name="diam" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="frequenza" name="frequenza" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="h" name="h" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="i" name="i" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="freq_prel" name="freq_prel" value=""/>
            </div>
        </span>
        <span>
            <div>
            <select id="poll_matr" name="poll_matr" value="">
                <option></option>
                <?php foreach( $d->getD1Coll()->getFirst()->getControl('poll_matr')->getItems() as $poll) :?>
                <option value="<?php echo $poll->getData('codice'); ?>"><?php echo $poll->getData('descriz'); ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formd&amp;action=editarbustive&amp;id=<?php echo $d->getData('objectid');?>" data-update="content_rilievidendrometrici_ird">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
            </a>
            </div>
        </span>
        </div>
    </div>
    <?php require (__DIR__.DIRECTORY_SEPARATOR.'listird.php');?>
</fieldset>
</fieldset>
<script type="text/javascript" src="js/ias.js" defer="defer"></script>