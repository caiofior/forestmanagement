<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b3 = $b->getB3Coll()->getFirst();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formb3.css";
</script>
    <div id="tabContent">
    <form id="formB3" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=update&amp;id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb3_errors" style="display: none;"></div>
        <a class="deleteTab" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid');?>" alt="Cancella Scheda">
            <img class="actions delete" src="images/empty.png" title="Cancella"/>
            Cancella scheda
        </a>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $b3->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>"/>
        </div>
        <div id="note_1">
            <h3 >Schede B3 per descrivere una formazione arbustiva-erbacea-improduttiva privo vegetazione</h3>
        </div>
        <div id="cod_part_container">
            <label  for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>"/>
        </div>
        <div id="t_container">
            <label for="t" >Tipo forestale</label>
            <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t');?>"/>
            <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz');?>"/>
        </div>
        <fieldset id="ucontainer" >
            <legend>Tipo</legend>
            <div>
        <?php
        $labels=array(
          3=> 'formazione arbustiva',
          4=> 'incolto erbaceo',
          5=> 'pascolo',
          6=> 'prato pascolo',
          7=> 'coltivo',
          9=> 'improduttivo privo veget.',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b->getData('u'))
            $checked = 'checked="checked"';
        ?>
        <input type="checkbox" name="u" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
        <?php endforeach;?>
            </div>
        </fieldset>
        </fieldset>
        <p id="tab1note">Formazione arbustiva</p>
        <fieldset id="tab1container">
        <div id="hcontainer">
            <label for="h">Altezza media</label>
            <input id="h" name="h" value="<?php echo $b3->getData('h');?>"/>
        </div>      
        <div id="cop_arbucontainer">
            <label for="cop_arbu">Copertura (%)</label>
            <input id="cop_arbu" name="cop_arbu" value="<?php echo $b3->getData('cop_arbu');?>"/>
        </div>
        <fieldset id="secontainer" >
        <legend>Diffusione strato erbacee</legend>
        <?php
        foreach($b3->getControl('se')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('se'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="se" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="arbustivecontainer" >
        <legend><span>Strato arbustivo -<br/> specie significative</span></legend>
        <div id="newarbustive">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu_ar" name="cod_coltu_ar" value=""/>
                <input id="cod_coltu_ar_descr" name="cod_coltu_ar_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editarbustive&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_arbustive">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'arbustive.php');?>
        </fieldset>
        <fieldset id="erbaceecontainer" >
        <legend><span>Specie erbacee <br/>significative</span></legend>
        <div id="newerbacee">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu_er" name="cod_coltu_er" value=""/>
                <input id="cod_coltu_er_descr" name="cod_coltu_er_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editerbacee&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_erbacee">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'erbacee.php');?>
        </fieldset>
        </fieldset>
        <fieldset id="tab2container">
        <p id="tab2note">Incolto erbaceo</p>
        <div id="cop_erbacontainer">
            <label for="cop_erba">Copertura (%)</label>
            <input id="cop_erba" name="cop_erba" value="<?php echo $b3->getData('cop_erba');?>"/>
        </div>      
        <div id="sr_perccontainer">
            <label for="sr_perc">Copertura  strato arbustivo % </label>
            <input id="sr_perc" name="sr_perc" value="<?php echo $b3->getData('sr_perc');?>"/>
        </div>
        </fieldset>
        <fieldset id="tab3container">
        <p id="tab3note">Pascolo/Prato-pascolo</p>
        <fieldset id="comp_coticontainer" >
        <legend>Composizione cotico</legend>
        <?php
        foreach($b3->getControl('comp_coti')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('comp_coti'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="comp_coti" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="dens_coticontainer" >
        <legend>Densità cotico</legend>
        <?php
        foreach($b3->getControl('dens_coti')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('dens_coti'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="dens_coti" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="infestanticontainer" >
        <legend>Infestanti</legend>
        <?php
        foreach($b3->getControl('infestanti')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('infestanti'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="infestanti" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="infestantisscontainer" >
        <legend>Infestanti - specie significative</legend>
        <div id="newinfestanti">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="infestanti_er" name="infestanti_er" value=""/>
                <input id="infestanti_er_descr" name="infestanti_er_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editinfestanti&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_infestanti">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie infestante"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'infestanti.php');?>
        </fieldset>
        <fieldset id="modalpascocontainer" >
        <legend>Modalità pascolo</legend>
        <?php
        foreach($b3->getControl('modalpasco')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('modalpasco'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="modalpasco" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <div id="duratapasccontainer">
            <label for="duratapasc">Durata (giorni)</label>
            <input id="duratapasc" name="duratapasc" value="<?php echo $b3->getData('duratapasc');?>"/>
        </div>
        <fieldset id="fruitoricontainer" >
        <legend>Specie pascolante</legend>
        <?php
        foreach($b3->getControl('fruitori')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('fruitori'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="fruitori" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="caricopasccontainer" >
        <legend>Carico</legend>
        <?php
        foreach($b3->getControl('caricopasc')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('caricopasc'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="caricopasc" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <div id="n_capicontainer">
            <label for="n_capi">UBA/ha</label>
            <input id="n_capi" name="n_capi" value="<?php echo $b3->getData('n_capi');?>"/>
        </div>
        <fieldset id="disph2ocontainer" >
        <legend>Disponibilità acqua</legend>
        <?php
        foreach($b3->getControl('disph2o')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('disph2o'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="disph2o" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <div id="n_abbeveracontainer">
            <label for="n_abbevera">Numero abbeveratoi</label>
            <input id="n_abbevera" name="n_abbevera" value="<?php echo $b3->getData('n_abbevera');?>"/>
        </div>
        <fieldset id="stato_abbecontainer" >
        <legend>Stato abbeveratoi</legend>
        <?php
        foreach($b3->getControl('stato_abbe')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('stato_abbe'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="stato_abbe" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="possmeccanecontainer" >
        <legend>Possibilità meccanizzazione</legend>
        <?php
        foreach($b3->getControl('possmeccan')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('possmeccan'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="possmeccan" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="possmungitcontainer" >
        <legend>Possibilità spostamento mungitrici</legend>
        <?php
        foreach($b3->getControl('possmungit')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('possmungit'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="possmungit" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="infr_pastcontainer" >
        <legend>Infrastrutture pastorali</legend>
        <?php
        foreach($b3->getControl('infr_past')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('infr_past'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="infr_past" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        
        </fieldset>
        <fieldset id="tab4container">
        <fieldset id="arboreecontainer" >
        <legend>Composizione strato arboreo</legend>
        <div id="newarboree">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu" name="cod_coltu" value=""/>
                <input id="cod_coltu_descr" name="cod_coltu_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editarboree&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_arboree">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'arboree.php');?>
        </fieldset>
        <div id="cop_arbocontainer">
            <label for="cop_arbo">Copertura (%)</label>
            <input id="cop_arbo" name="cop_arbo" value="<?php echo $b3->getData('cop_arbo');?>"/>
        </div>
        <fieldset id="n1container" >
        <legend>Novellame</legend>
        <?php
        foreach($b3->getControl('n1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('n1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n1arrow_right"></fieldset>
        <fieldset id="n2container" >
        <?php
        foreach($b3->getControl('n2')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('n2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n2" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="rinnovazionecontainer" >
        <legend>Composizione rinnovazione</legend>
        <div id="newrinnovazione">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltur" name="cod_coltur" value=""/>
                <input id="cod_coltur_descr" name="cod_coltur_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editrinnovazione&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_rinnovazione">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'rinnovazione.php');?>
        </fieldset>
        <div id="f_container">
        <label for="f">Funzione principale</label>
        <select id="f" name="f">
            <option value="">Scegli una funzione</option>
            <?php
            foreach($b3->getControl('f')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b3->getData('f') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="f2_container">
        <label for="f2">Funzione accessoria</label>
        <select id="f2" name="f">
            <option value="">Scegli una funzione</option>
            <?php
            foreach($b3->getControl('f2')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b3->getData('f2') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="p2_container">
        <label for="p2">Ipotesi di intervento</label>
        <select id="p2" name="p2">
            <option value="">Scegli un'ipotesi</option>
            <?php
            foreach($b3->getControl('p2')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b3->getData('p2') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="p3_container">
        <label for="p3">Ipotesi di intervento (secondario)</label>
        <select id="p3" name="p3">
            <option value="">Scegli un'ipotesi</option>
            <?php
            foreach($b3->getControl('p3')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b3->getData('p3') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <div id="p4_container">
            <label for="p4">Specifiche interventi di altro tipo</label>
            <input id="p4" name="p4" value="<?php echo $b3->getData('p4');?>"/>
        </div>
        <fieldset id="g1container" >
        <legend>Priorità e condizionamenti</legend>
        <?php
        foreach($b3->getControl('g1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('g1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="g1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="g1arrow_right"></fieldset>
        <fieldset id="sub_viabcontainer" >
        <legend><span>Subordinato alla viabilità</span></legend>
        <?php
        foreach($b3->getControl('sub_viab')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('sub_viab'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sub_viab" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        </fieldset>
        <fieldset id="tab5container">
         <p id="tab5note">Coltivo</p>
        <fieldset id="coltcontainer" >
        <?php
        $labels=array(
          7=> 'colture erbacee',
          8=> 'colture arboree',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b3->getData('u'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="colt" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="alberaturecontainer" >
        <legend>Composizione alberature</legend>
        <div id="newalberature">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltut" name="cod_coltut" value=""/>
                <input id="cod_coltut_descr" name="cod_coltut_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editalberature&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_alberature">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'alberature.php');?>
        </fieldset>
        <fieldset id="diffalbcolcontainer" >
        <legend>Diffusione alberature</legend>
        <?php
        foreach($b3->getControl('diffalbcol')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('diffalbcol'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="diffalbcol" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <p id="tab5note2">N.B. nel caso di un coltivo deve essere compilato anche il quadro sovrastante</p>
        <fieldset id="colarrow_up"></fieldset>
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
                    <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editnote&amp;id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_note">
                        <img class="actions addnew" src="images/empty.png" title="Aggiungi una nota"/>
                    </a>
                </span>
            </div>
        </div>
        <?php
        require __DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'note.php';
        ?>
        </fieldset>
        <fieldset id="forestnotecontainer">
            <legend>Note</legend>
            <textarea id="note" name="note" rows="16" cols="45"><?php echo $b3->getData('note');?></textarea>
        </fieldset>
        </fieldset>
        
    </form>
</div>
<script type="text/javascript" src="js/formb3.js" defer="defer"></script>
</div>