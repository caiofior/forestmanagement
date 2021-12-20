<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$n = $b->getNColl()->getFirst();

?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formn.css";
</script>
    <div id="tabContent">
        <form id="formN" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formn&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formn_errors" style="display: none;"></div>
        <a class="deleteTab" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid');?>" alt="Cancella Scheda">
            <img class="actions delete" src="images/empty.png" title="Cancella"/>
            Cancella scheda
        </a>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $n->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="codiope_container">
            <label for="codiope">Rilevatore</label>
            <input type="hidden" id="codiope" name="codiope" value="<?php echo $n->getData('codiope');?>"/>
            <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $n->getCollector()->getData('descriz');?>"/>
        </div>
        <div id="datasch_container">
            <label for="datasch">Data del rilievo</label>
            <input id="datasch" name="datasch" value="<?php echo $n->getData('datasch');?>">
        </div>
        <div id="note_1">
            <h3 >Schede N<br/>REGISTRO DEGLI EVENTI</h3>
        </div>
        <div id="sup_container">
            <label for="sup">Superficie (ha)</label>
            <input id="sup" name="sup" value="<?php echo $n->getData('sup');?>">
        </div>
        <div id="lung_container">
            <label for="lung">Lunghezza (m)</label>
            <input id="lung" name="lung" value="<?php echo $n->getData('lung');?>">
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella/<br/>Sottoparticella</label>
            <input id="cod_part" readonly="readonly" name="cod_part" value="<?php echo $n->getData('cod_part');?>">
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella/<br/>Sottoparticella</label>
            <input id="cod_part" readonly="readonly" name="cod_part" value="<?php echo $n->getData('cod_part');?>">
        </div>
        <div id="cod_ev_int_container">
            <label for="cod_ev_int">Codice evento</label>
            <input id="cod_ev_int" name="cod_ev_int" value="<?php echo $n->getData('cod_part');?>">
        </div>
        <div id="dataeven_container">
            <label for="dataeven">Mese e Anno</label>
            <input id="dataeven" name="dataeven" value="<?php echo $n->getData('dataeven');?>">
        </div>
        <fieldset id="l_container" >
            <legend>LOCALIZZAZIONE nella parte.....</legend>
            <div>
        <?php
        $labels=array(
          1=> 'N',
          2=> 'E',
          3=> 'S',
          4=> 'O',
          5=> 'Centrale',
          6=> 'Alta',
          7=> 'Bassa',
          8=> 'Sul crinale',
          9=> 'A mezza costa',
          10=>'Nei compluvi',
          11=>'Sui dossi',
          12=>'Presso i fossi',
          13=>'Lungo la strada',
          14=>'Altrove'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $n->getData('l'))
            $checked = 'checked="checked"';
        ?>
        <input type="checkbox" name="l" <?php echo $checked; ?> value="<?php echo $key; ?>"/><div><?php echo $item; ?></div>
        <?php if ($key/4 == intval($key/4)) : ?>
        <br/>
        <?php endif;
        endforeach;?>
            </div>
            <div id="l1_container">
            <label for="l1">specificare</label>
            <input id="l1" name="l1" value="<?php echo $n->getData('l1');?>">
            </div>
        </fieldset>
        <fieldset id="eve_int_container" >
            <legend>Tipo</legend>
            <div>
        <?php
        $labels=array(
          1=> 'Evento',
          2=> 'Intervento',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $n->getData('eve_int'))
            $checked = 'checked="checked"';
        ?>
        <input type="checkbox" name="eve_int" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </fieldset>
        </fieldset>
        <fieldset id="dati_evento">
            <p>Evento</p>
        <fieldset id="evento_container" >
            <legend>Tipo di evento</legend>
            <div>
        <?php
        $labels=array(
          1=> 'Incendio',
          2=> 'Frana',
          3=> 'Agenti meteorici',
          4=> 'Movimenti di neve',
          5=> 'Eventi di altro tipo',  
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $n->getData('eve_int'))
            $checked = 'checked="checked"';
        ?>
        <input type="checkbox" name="eve_int" <?php echo $checked; ?> value="<?php echo $key; ?>"/><div><?php echo $item; ?></div>
        <?php endforeach;?>
        <div id="spec_event_container">
            <label for="spec_event">specifica</label>
            <input id="spec_event" name="spec_event" value="<?php echo $n->getData('spec_event');?>">
        </div>
        </fieldset>
        <div id="desc_eve_container">
            <label for="desc_eve">Descrizione degli eventi imprevisti, cause ed effetti </label>
            <textarea id="desc_eve" name="desc_eve" ><?php echo $n->getData('desc_eve');?></textarea>
        </div>
        </fieldset>
        <fieldset id="dati_intervento">
            <p>Intervento</p>
        <fieldset id="tipo_inter_container" >
            <legend>Tipo di intervento</legend>
            <div>
        <?php
        $labels=array(
          1=> 'Formazioni arboree',
          2=> 'Formazioni specializzate',
          3=> 'Formazioni arbustive ed erbacee',
          4=> 'Viabilità',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $n->getData('tipo_inter'))
            $checked = 'checked="checked"';
        ?>
        <input type="checkbox" name="tipo_inter" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </fieldset>
        <div id="intervento_container">
        <label for="intervento">Intervento formazioni arboree</label>
        <select id="intervento" name="intervento">
            <option value="">Scegli una funzione</option>
            <?php
            foreach($n->getControl('intervento')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $n->getData('intervento') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="m_prev_container">
            <label for="m_prev">Massa prevista (m&#179;/ha)</label>
            <input id="m_prev" name="m_prev" value="<?php echo $n->getData('m_prev');?>">
        </div>
        <div id="intervento_specia_container">
        <label for="intervento_specia">Intervento formazioni specializzate</label>
        <select id="intervento_specia" name="intervento_specia">
            <option value="">Scegli una funzione</option>
            <?php
            foreach($n->getControl('intervento_specia')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $n->getData('intervento_specia') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="m_prel_container">
            <label for="m_prel">Massa prelevata (m&#179;/ha)</label>
            <input id="m_prel" name="m_prel" value="<?php echo $n->getData('m_prel');?>">
        </div>
        <div id="intervento_arbus_container">
        <label for="intervento_arbus">Intervento formazioni arbustive ed erbacee</label>
        <select id="intervento_arbus" name="intervento_arbus">
            <option value="">Scegli una funzione</option>
            <?php
            foreach($n->getControl('intervento_arbus')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $n->getData('intervento_arbus') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="intervento_viabil_container">
        <label for="intervento_viabil">Intervento viabilità</label>
        <select id="intervento_viabil" name="intervento_viabil">
            <option value="">Scegli una funzione</option>
            <?php
            foreach($n->getControl('intervento_viabil')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $n->getData('intervento_viabil') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="desc_modi_container">
            <label for="desc_modi">eventuali modifiche alle prescrizioni e loro causa </label>
            <textarea id="desc_modi" name="desc_modi" ><?php echo $n->getData('desc_modi');?></textarea>
        </div>
        <div id="desc_effet_container">
            <label for="desc_effet">valutazione di massima degli effetti degli interventi </label>
            <textarea id="desc_effet" name="desc_effet" ><?php echo $n->getData('desc_effet');?></textarea>
        </div>
        </fieldset>
        <fieldset id="notescontainer">
        <legend>Note alle singole voci</legend>
        <div id="newnote">
                <div>
                    <span>
                        <div>Parametro</div>
                    </span>
                    <span>
                        <div>Nota</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
                <span>
                    <input type="hidden" id="cod_nota" name="cod_nota" value=""/>
                    <input id="cod_nota_descr" name="cod_nota_descr" value=""/>
                </span>

                <span>
                    <textarea id="text_nota" name="text_nota" rows="2" cols="30"></textarea>
                </span>
                <span>
                    <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formn&amp;action=editnote&amp;id=<?php echo $n->getData('objectid');?>" data-update="content_schedan_note">
                        <img class="actions addnew" src="images/empty.png" title="Aggiungi una nota"/>
                    </a>
                </span>
            </div>
        </div>
        <?php
        require __DIR__.DIRECTORY_SEPARATOR.'schedan'.DIRECTORY_SEPARATOR.'note.php';
        ?>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formn.js" defer="defer"></script>
</div>