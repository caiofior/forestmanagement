<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b2 = $b->getB2Coll()->getFirst();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formb2.css";
</script>
    <div id="tabContent">
    <form id="formB2" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&amp;action=update&amp;id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb2_errors" style="display: none;"></div>
        <a class="deleteTab" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid');?>" alt="Cancella Scheda">
            <img class="actions delete" src="images/empty.png" title="Cancella"/>
            Cancella scheda
        </a>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $b2->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="note_1">
            <h3 >Schede B2 per descrivere una formazione specializzata per produzioni non legnose od impianti per arboricoltura da legno</h3>
        </div>
        <div id="cod_part_container">
            <label class="double" for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>"/>
        </div>
        <div id="t_container">
            <label for="t" class="double">Tipo forestale</label>
            <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t');?>"/>
            <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz');?>"/>
        </div>
        <fieldset id="ucontainer" >
            <legend>Tipo</legend>
            <div>
        <?php
        $labels=array(
          10=> 'arboricoltura specializzata da legno',
          2=> 'castagneti da frutto',
          11=> 'impianti specializzati per tartuficoltura',
          12=> 'sugherete'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b->getData('u'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="u" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
        <?php endforeach;?>
            </div>
        </fieldset>
        </fieldset>


        <fieldset id="tab1container">
        <p id="tab1note">Arboricoltura specializzata da legno</p>
        <fieldset id="tipocontainer">
            <legend>Tipo di impianto</legend>
            <div>
        <?php
        foreach($b2->getControl('tipo')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('tipo'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="tipo" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="anno_imp_container">
            <label for="anno_imp">Anno d'impianto</label>
            <input id="anno_imp" name="anno_imp" value="<?php echo $b2->getData('anno_imp');?>">
        </div>
        <div id="anno_dest_container">
            <label for="anno_dest">Anno di possibile cambio di destinazione</label>
            <input id="anno_dest" name="anno_dest" value="<?php echo $b2->getData('anno_dest');?>">
        </div>
        <fieldset id="comp_specontainer" >
        <legend>Composizione specifica</legend>
        <div>
        <?php
        foreach($b2->getControl('comp_spe')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('comp_spe'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="comp_spe" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="cod_coltup_container">
            <label for="cod_coltup">Specie principale componente arborea</label>
            <input type="hidden" id="cod_coltup" name="cod_coltup" value="<?php echo $b2->getData('cod_coltup');?>"/>
            <input id="cod_coltup_descr" name="cod_coltup_descr" value="<?php echo $b2->getRawData('cod_coltup_descriz');?>"/>
        </div>
        <div id="cod_coltus_container">
            <label for="cod_coltus">Specie secondaria componente arborea</label>
            <input type="hidden" id="cod_coltus" name="cod_coltus" value="<?php echo $b2->getData('cod_coltus');?>"/>
            <input id="cod_coltus_descr" name="cod_coltus_descr" value="<?php echo $b2->getRawData('cod_coltus_descriz');?>"/>
        </div>
        <div id="dist_container">
            <label for="dist">Distanza tra le piante</label>
            <input id="dist" name="dist" value="<?php echo $b2->getData('dist');?>"/>
        </div>
        <div id="dist_princ_container">
            <label for="dist_princ">Distanza tra le piante della specie principale</label>
            <input id="dist_princ" name="dist_princ" value="<?php echo $b2->getData('dist_princ');?>"/>
        </div>
        <fieldset id="sesto_imp_arbcontainer" >
        <legend>Sesto d'impianto</legend>
        <div>
        <?php
        foreach($b2->getControl('sesto_imp_arb')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('sesto_imp_arb'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_arb" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="sesto_imp_sp_princ_arbcontainer" >
        <legend>Sesto d'impianto specie principale</legend>
        <div>
        <?php
        foreach($b2->getControl('sesto_princ')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('sesto_princ'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_princ" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_arb_princcontainer" >
        <legend>Vigoria specie principale</legend>
        <div>
        <?php
        foreach($b2->getControl('vig_arb_princ')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('vig_arb_princ'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_arb_princ" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_arb_seccontainer" >
        <legend>Vigoria specie secondaria</legend>
        <div>
        <?php
        foreach($b2->getControl('vig_arb_sec')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('vig_arb_sec'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_arb_sec" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="fall_container">
            <label for="fall">Fallanze (%)</label>
            <input id="fall" name="fall" value="<?php echo $b2->getData('fall');?>"/>
        </div>
        <fieldset id="qual_pricontainer" >
        <legend>Qualità fusto specie principale</legend>
        <div>
        <?php
        foreach($b2->getControl('qual_pri')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('qual_pri'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="qual_pri" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="line1tab1"></div>
        <div id="line2tab1"></div>
        </fieldset>
        <fieldset id="tab2container">
        <p id="tab2note">Castagneto da frutto</p>
        <fieldset id="colt_castcontainer" >
        <legend>Stato</legend>
        <div>
        <?php
        foreach($b2->getControl('colt_cast')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('colt_cast'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="colt_cast" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_castcontainer" >
        <legend>Vigoria</legend>
        <div>
        <?php
        foreach($b2->getControl('vig_cast')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('vig_cast'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_cast" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="sesto_imp_castcontainer" >
        <legend>Sesto d'impianto</legend>
        <div>
        <?php
        foreach($b2->getControl('sesto_imp_cast')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('sesto_imp_cast'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_cast" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="line1tab2"></div>
        <div id="line2tab2"></div>
        </fieldset>
        <fieldset id="tab3container">
        <p id="tab3note">Impianti speciali per la tartuficoltura</p>
        <div id="cod_coltub_container">
            <label for="cod_coltub">Specie simbionte</label>
            <input type="hidden" id="cod_coltub" name="cod_coltub" value="<?php echo $b2->getData('cod_coltub');?>"/>
            <input id="cod_coltub_descr" name="cod_coltub_descr" value="<?php echo $b2->getRawData('cod_coltub_descriz');?>"/>
        </div>
        <div id="cod_coltua_container">
            <label for="cod_coltua">Specie forestale accessoria</label>
            <input type="hidden" id="cod_coltua" name="cod_coltua" value="<?php echo $b2->getData('cod_coltua');?>"/>
            <input id="cod_coltua_descr" name="cod_coltua_descr" value="<?php echo $b2->getRawData('cod_coltua_descriz');?>"/>
        </div>
        <div id="fungo_ospi_container">
        <label for="fungo_ospi">Fungo ospite</label>
        <select>
        <option value="">Seleziona una specie</option>
        <?php
        foreach($b2->getControl('fungo_ospi')->getItems() as $item) :
        $selected = '';
        if ($item->getRawData('cod_coltu') == $b2->getData('fungo_ospi'))
            $selected = 'selected="selected"';
        ?>
        <option name="fungo_ospi" <?php echo $selected; ?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('nome'); ?></option>
        <?php endforeach;?>
        </select>
        </div>
        <fieldset id="sesto_imp_tartcontainer" >
        <legend>Sesto d'impianto</legend>
        <div>
        <?php
        foreach($b2->getControl('sesto_imp_tart')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('sesto_imp_tart'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_tart" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="num_piante_container">
            <label for="num_piante">N° totale piante (n/ha)</label>
            <input id="num_piante" name="num_piante" value="<?php echo $b2->getData('num_piante');?>">
        </div>
        <div id="piant_tart_container">
            <label for="piant_tart">Piante tartufigene (n/ha)</label>
            <input id="piant_tart" name="piant_tart" value="<?php echo $b2->getData('piant_tart');?>">
        </div>
        <div id="line1tab3"></div>
        <div id="line2tab3"></div>

        </fieldset>
        <fieldset id="tab4container">
        <p id="tab4note">Sughereta</p>
        <div id="s_container">
        <label for="s">Struttura</label>
        <select id="s" name="s">
            <option value="">Scegli un valore di copertura</option>
            <?php
            foreach($b2->getControl('s')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b2->getData('s') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
        </select>
        </div>
        <fieldset id="arboreecontainer" >
        <legend>Composizione strato arboreo</legend>
        <div id="newarboree">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Copertura</div>
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
                <input id="cod_coper2" name="cod_coper2" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&amp;action=editerbacee&amp;id=<?php echo $b2->getData('objectid');?>" data-update="content_schedab2_arboree">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab2'.DIRECTORY_SEPARATOR.'arboree.php');?>
        </fieldset>
        <fieldset id="ocontainer" >
        <legend>Origine</legend>
        <div>
        <?php
        $labels=array(
          1=> 'dissemin.',
          2=> 'artificiale',
          3=> 'agamica o ceduo in conver.',
          4=> 'bosco di neoformazione',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('o'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="o" <?php echo $checked; ?> value="<?php echo $key; ?>"><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
                <fieldset id="vig_sugcontainer" >
        <legend>Vigoria</legend>
        <div>
        <?php
        $labels=array(
          1=> 'poco vigoros',
          2=> 'mediamente',
          3=> 'molto vigoros'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('vig_sug'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_sug" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="vig_sug_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="fito_sugcontainer" >
        <legend>Stato fitosanitario</legend>
        <div>
        <?php
        $labels=array(
          1=> 'precario',
          2=> 'medio',
          3=> 'buono'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('fito_sug'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="fito_sug" <?php echo $checked; ?> value="<?php echo $key; ?>"><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="fito_bio_container">
            <label for="fito_bio">agenti biologici</label>
            <input type="checkbox" <?php echo ($b2->getData('fito_bio')==1 ? 'checked="checked"' : ''); ?> id="fito_bio" name="fito_bio"value ="1">
        </div>
        <div id="fito_bio_spec_container">
            <label for="fito_bio_spec">Specifiche</label>
            <input id="fito_bio_spec" name="fito_bio_spec"value ="<?php echo $b2->getData('fito_bio_spec') ; ?>">
        </div>
        <div id="fito_abio_container">
            <label for="fito_abio">agentio abioti</label>
            <input type="checkbox" <?php echo ($b2->getData('fito_abio')==1 ? 'checked="checked"' : ''); ?> id="fito_abio" name="fito_abio"value ="1">
        </div>
        <div id="fito_abio_spec_container">
            <label for="fito_abio_spec">Specifiche</label>
            <input id="fito_abio_spec" name="fito_abio_spec"value ="<?php echo $b2->getData('fito_abio_spec') ; ?>">
        </div>
        <fieldset id="vcontainer" >
        <legend>Vuoti -lacune</legend>
        <div>
        <?php
        $labels=array(
          1=> 'assenti',
          2=> 'presenti'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('v'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="v" <?php echo $checked; ?> value="<?php echo $key; ?>"><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="dcontainer" >
        <legend>Densità</legend>
        <div>
        <?php
        foreach($b2->getControl('d')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('d'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="d" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n1container" >
        <legend>Novellame</legend>
        <div>
        <?php
        foreach($b2->getControl('n1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('n1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n1arrow_right"></fieldset>
        <fieldset id="n2container" >
        <div>
        <?php
        foreach($b2->getControl('n2')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('n2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n2" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n3container" >
        <legend>Rinnovazione</legend>
        <div>
        <?php
        $labels=array(
          1=> 'sufficiente',
          2=> 'insufficiente'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('n3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n3" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n3arrow_right"></fieldset>
        <div id="spe_nov_container">
            <label for="spe_nov">Specie prevalente rinnovazione</label>
            <?php 
            $rennovationspecie = $b2->getRennovationSpecie();
            $value = '';
            if ($b2->getData('spe_nov') != '')
                $value = $rennovationspecie->getData('nome_itali').' | '.$rennovationspecie->getData('nome_scien');
            ?>
            <input type="hidden" id="spe_nov" name="spe_nov" value="<?php echo $b2->getData('spe_nov');?>"/>
            <input id="spe_nov_descr" name="spe_nov_descr" value="<?php echo $value; ?>" data-old-value="<?php echo $value; ?>"/>
        </div>
        <div id="tipo_int_sug_container">
            <label for="tipo_int_sug">Categorie intervento per sugherete</label>
            <select id="tipo_int_sug" name="tipo_int_sug">
            <option value="">Scegli un tipo di intervento</option>
            <?php
            foreach($b2->getControl('tipo_int_sug')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b2->getData('tipo_int_sug') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
            </select>
        </div>
        <div id="int2_container">
            <label for="int2">Interventi recenti</label>
            <select id="int2" name="int2">
            <option value="">Scegli un tipo di intervento</option>
            <?php
            foreach($b2->getControl('int2')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b2->getData('int2') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
            </select>
        </div>
        <div id="int3_container">
            <label for="int3">Specifiche</label>
            <input id="int3" name="int3"value ="<?php echo $b2->getData('int3') ; ?>"/>
        </div>
        <div id="estraz_passata_container">
            <label for="estraz_passata">Anno estrazione sughero</label>
            <input id="estraz_passata" name="estraz_passata"value ="<?php echo $b2->getData('estraz_passata') ; ?>"/>
        </div>
                <fieldset id="dsugcontainer">
            <legend>Dati di orientamento dendrometrico</legend>
            <div id="d5_container">
                <label class="double" for="d5">n° alberi /ha</label>
                <input id="d5" name="d5"value ="<?php echo $b2->getData('d5') ; ?>"/>
            </div>
            <div id="d10_container">
                <label for="d10">n° alberi produttivi/ha</label>
                <input id="d10" name="d10"value ="<?php echo $b2->getData('d10') ; ?>"/>
            </div>
            <div id="d11_container">
                <label class="double" for="d11">n° polloni/ha</label>
                <input id="d11" name="d11"value ="<?php echo $b2->getData('d11') ; ?>"/>
            </div>
            <div id="d12_container">
                <label class="double" for="d12">n° monocauli/ha</label>
                <input id="d12" name="d12"value ="<?php echo $b2->getData('d12') ; ?>"/>
            </div>
            <div id="d1_container">
                <label for="d1">diametro preval.(cm)</label>
                <input id="d1" name="d1"value ="<?php echo $b2->getData('d1') ; ?>"/>
            </div>
            <div id="d3_container">
                <label for="d3">altezza preval.(cm)</label>
                <input id="d3" name="d3"value ="<?php echo $b2->getData('d3') ; ?>"/>
            </div>
            <div id="d13_container">
                <label class="double" for="d13">Produzione media (q)</label>
                <input id="d13" name="d13"value ="<?php echo $b2->getData('d13') ; ?>"/>
            </div>
        </fieldset>

        </fieldset>


        <fieldset id="tab5container">
            <div id="c1_container">
                <label for="c1">Età prevalente accertata</label>
                <input id="c1" name="c1"value ="<?php echo $b2->getData('c1') ; ?>">
            </div>
            <div id="ce_container">
                <label for="ce">Copertura</label>
                <input id="ce" name="ce"value ="<?php echo $b2->getData('ce') ; ?>">
            </div>
                    <fieldset id="srcontainer" >
        <legend>Strato arbustivo</legend>
        <?php
        foreach($b2->getControl('sr')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('sr'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sr" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span class="sr_descr"><?php echo $item->getData('descriz'); ?></span><br/>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="arbustivecontainer" >
        <legend>Specie arbustive significative</legend>
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
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&amp;action=editarbustive&amp;id=<?php echo $b2->getData('objectid');?>" data-update="content_schedab2_arbustive">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab2'.DIRECTORY_SEPARATOR.'arbustive.php');?>
        </fieldset>
        <fieldset id="secontainer" >
        <legend>Strato erbaceo</legend>
        <?php
        foreach($b2->getControl('se')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('se'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="se" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span class="se_descr"><?php echo $item->getData('descriz'); ?></span><br/>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="erbaceecontainer" >
        <legend>Specie erbacee significative</legend>
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
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&amp;action=editerbacee&amp;id=<?php echo $b2->getData('objectid');?>" data-update="content_schedab2_erbacee">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab2'.DIRECTORY_SEPARATOR.'erbacee.php');?>
        </fieldset>

            <div id="tipo_prescr_sug_container">
                <label for="tipo_prescr_sug">Interventi recenti</label>
                <select id="tipo_prescr_sug" name="tipo_prescr_sug">
                <option value="">Scegli un tipo di intervento</option>
                <?php
                foreach($b2->getControl('tipo_prescr_sug')->getItems() as $item) : ?>
                <option <?php echo ($item->getData('codice') == $b2->getData('tipo_prescr_sug') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div id="p2_container">
                <label for="p2">Ipotesi di intervento</label>
                <select id="p2" name="p2">
                <option value="">Scegli un tipo di intervento</option>
                <?php
                foreach($b2->getControl('p2')->getItems() as $item) : ?>
                <option <?php echo ($item->getData('codice') == $b2->getData('p2') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div id="estraz_futura_container">
                <label for="estraz_futura">Anno previsto per estrazione sughero</label>
                <input id="estraz_futura" name="estraz_futura"value ="<?php echo $b2->getData('estraz_futura') ; ?>">
            </div>
            <div id="p3_container">
                <label for="p3">Ipotesi di intervento (secondaria)</label>
                <select id="p3" name="p3">
                <option value="">Scegli un tipo di intervento</option>
                <?php
                foreach($b2->getControl('p3')->getItems() as $item) : ?>
                <option <?php echo ($item->getData('codice') == $b2->getData('p3') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
                </select>
            </div>
            <div id="p4_container">
                <label for="p4">Specifiche interventi di altro tipo</label>
                <input id="p4" name="p4"value ="<?php echo $b2->getData('p4') ; ?>"/>
            </div>
                    <fieldset id="g1container" >
        <legend>Priorità e condizionamenti</legend>
        <div >
        <?php
        foreach($b2->getControl('g1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('g1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="g1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n5arrow_right"></fieldset>
        <fieldset id="sub_viabcontainer" >
        <legend>Subordinato alla viabilità</legend>
        <div >
        <?php
        foreach($b2->getControl('sub_viab')->getItems() as $key=>$item) :
        $checked = '';
        if ($item->getData('codice') == $b->getData('sub_viab'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sub_viab" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="forestnotecontainer">
            <legend>Note</legend>
            <textarea id="note" name="note" rows="16" cols="45"><?php echo $b2->getData('note');?></textarea>
        </fieldset>
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
                    <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&amp;action=editnote&amp;id=<?php echo $b2->getData('objectid');?>" data-update="content_schedab2_note">
                        <img class="actions addnew" src="images/empty.png" title="Aggiungi una nota"/>
                    </a>
                </span>
            </div>
        </div>
        <?php
        require __DIR__.DIRECTORY_SEPARATOR.'schedab2'.DIRECTORY_SEPARATOR.'note.php';
        ?>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb2.js" defer="defer"></script>
</div>