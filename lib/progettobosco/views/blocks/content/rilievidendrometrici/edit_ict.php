<?php
$ccoll = $x->getCColl();
$ccoll->loadAll();
if($ccoll->count() == 0)
    $c = $ccoll->addItem();
else
    $c = $ccoll->getFirst();
?>
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/ict.css";
</script>
<fieldset>
<p >Scheda C per il rilievo dendrometrico ICT</p>
<div id="data_container">
    <label for="data">Data</label>
    <input readonly="readonly" id="data" name="data" value="<?php echo $x->getData('data');?>">
</div>
<div id="codiope_container">
    <label for="codiope">Rilevatore</label>
    <input type="hidden" id="codiope" name="codiope" value="<?php echo $c->getData('codiope');?>"/>
    <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $c->getCollector()->getData('descriz');?>"/>
</div>
<div id="c_anel_container">
    <label for="c_anel">Incremento radiale: osservazioni riferite ad uno spessore di &#8230;&#8230; mm</label>
    <input id="c_anel" name="c_anel" value="<?php echo $c->getData('c_anel');?>">
</div>
<div id="m_anel_container">
    <label for="m_anel">o ad un periodo di &#8230;&#8230; anni</label>
    <input id="m_anel" name="m_anel" value="<?php echo $c->getData('m_anel');?>">
</div>

<fieldset id="irc1_table_container" >
    <div >
            <div>
                <span>
                    <div>Diametro</div>
                </span>
                <span>
                    <div>Specie</div>
                </span>
                <span>
                    <div>Rilievo</div>
                </span>
                <span>
                    <div>Prelievo</div>
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
            <input id="diam" name="diam" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input type="hidden" id="specie" name="specie" value=""/>
            <input id="specie_descr" name="specie_descr" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="rilievo" name="rilievo" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="prelievo" name="prelievo" value=""/>
            </div>
        </span>
        <span>
            <div>
            <select id="poll_matr" name="poll_matr" value="">
                <option></option>
                <?php foreach( $c->getC1Coll()->getFirst()->getControl('poll_matr')->getItems() as $poll) :?>
                <option value="<?php echo $poll->getData('codice'); ?>"><?php echo $poll->getData('descriz'); ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formc1&amp;action=editarbustive&amp;id=<?php echo $c->getData('objectid');?>" data-update="content_rilievidendrometrici_ird">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
            </a>
            </div>
        </span>
        </div>
    </div>
    <?php require (__DIR__.DIRECTORY_SEPARATOR.'listict1.php');?>
</fieldset>
<fieldset id="irc2_table_container" >
    <div >
            <div>
                <span>
                    <div>Specie</div>
                </span>
                <span>
                    <div>Diametro</div>
                </span>
                <span>
                    <div>H</div>
                </span>
                <span>
                    <div>I</div>
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
            <input type="hidden" id="specie2" name="specie2" value=""/>
            <input id="specie2_descr" name="specie2_descr" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="diam2" name="diam2" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="h2" name="h2" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="i2" name="i2" value=""/>
            </div>
        </span>
        <span>
            <div>
            <select id="poll_matr2" name="poll_matr2" value="">
                <option></option>
                <?php foreach( $c->getC2Coll()->getFirst()->getControl('poll_matr')->getItems() as $poll) :?>
                <option value="<?php echo $poll->getData('codice'); ?>"><?php echo $poll->getData('descriz'); ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formc2&amp;action=editarbustive&amp;id=<?php echo $c->getData('objectid');?>" data-update="content_rilievidendrometrici_ird">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
            </a>
            </div>
        </span>
        </div>
    </div>
    <?php require (__DIR__.DIRECTORY_SEPARATOR.'listict2.php');?>
</fieldset>
<div id="note_container">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="5" cols="15"><?php echo $c->getData('note');?></textarea>
</div>
</fieldset>
<script type="text/javascript" src="js/ict.js" defer="defer"></script>