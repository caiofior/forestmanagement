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
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formb1.css";
</script>
    <div id="tabContent">
        <form id="formB1" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb1_errors" style="display: none;"></div>
        <a class="deleteTab" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid');?>" alt="Cancella Scheda">
            <img class="actions delete" src="images/empty.png" title="Cancella"/>
            Cancella scheda
        </a>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $b1->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="note_1">
            <h3 >Schede B per descrivere una formazione arborea</h3>
        </div>
        <div id="u_container">
            <label class="double" for="u">Tipo: formazione arborea</label>
            <input type="checkbox" id="u" name="u" <?php echo ( $b->getData('u') == 1 ? 'checked="checked"' : ''); ?>>
        </div>
        <div id="t_container">
            <label for="t" class="double">Tipo forestale</label>
            <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t');?>">
            <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz');?>">
        </div>
        <div id="cod_part_container">
            <label class="double" for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        <div id="s_container">
            <label for="s" class="double">Struttura e sviluppo</label>
            <input type="hidden" id="s" name="s" value="<?php echo $b1->getData('s');?>">
            <input data-old-descriz="<?php echo $b1->getStructure()->getData('descriz'); ?>" id="s_descriz" name="s_descriz" value="<?php echo $b1->getStructure()->getData('descriz');?>">
        </div>
        <fieldset id="mcontainer" >
        <legend>Matricinatura</legend>
        <?php
        foreach($b1->getControl('m')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('m'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="m" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="m_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="ocontainer" >
        <legend>Origine del bosco</legend>
        <?php
        $labels=array(
          1=> 'dissem. naturale',
          2=> 'artificiale',
          3=> 'agamica o<br/>ceduo in conver.',
          4=> 'incerta',
          5=> 'bosco di<br/> neoformazione'
        );
        foreach($b1->getControl('o')->getItems() as $item) :
        if ($item->getRawData('codice') == 4)
            continue;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('o'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="o" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><div ><?php echo $labels[$item->getRawData('codice')]; ?></div>
        <?php endforeach;?>
        </fieldset>
        <div id="c1_container">
            <label for="c1">Età prevalente accertata</label>
            <input id="c1" name="c1" value="<?php echo $b1->getData('c1');?>">
        </div>
        <fieldset id="vigcontainer" >
        <legend>Vigoria</legend>
        <?php
        foreach($b1->getControl('vig')->getItems() as $item) :
        if ($item->getRawData('codice') == 4)
            continue;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('vig'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
         <fieldset id="vcontainer" >
        <legend>Vuoti - lacune</legend>
        <?php
        foreach($b1->getControl('v')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('v'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="v" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="v_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <div id="ce_container">
            <label for="ce">Grado di copertura (%)</label>
            <input id="ce" name="ce" value="<?php echo $b1->getData('ce');?>">
        </div>
        <fieldset id="dcontainer" >
        <legend>Densità</legend>
        <?php
        $labels=array(
            2=>'Scarsa',
            3=>'Adeguata',
            4=>'Eccessiva'
        );
        foreach($b1->getControl('d')->getItems() as $item) :
        if (!key_exists($item->getRawData('codice'), $labels))
                continue;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('d'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="d" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="d_descr"><?php echo $labels[$item->getRaWData('codice')]; ?></span>
        <?php endforeach;?>
        </fieldset>
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
                <select id="cod_coper" name="cod_coper">
                    <option value="">Scegli un valore di copertura</option>
                    <?php
                    $forestcovercomposition = new \forest\attribute\covercomposition\B1();
                    $cod_coper_coll= $forestcovercomposition->getControl('cod_coper');
                    foreach($cod_coper_coll->getItems() as $item) : ?>
                    <option value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                    <?php endforeach;?>
                </select>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editarboree&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_arboree">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arborea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'arboree.php');?>
        </fieldset>
        <fieldset id="prep_terrcontainer" >
        <legend>Preparazione terreno</legend>
        <?php
        foreach($b1->getControl('prep_terr')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('prep_terr'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="prep_terr" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span ><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>


        <fieldset id="sestocontainer" >
        <legend>Sesto d'impianto</legend>
        <div id="sesto_imp_tra_file_container">
            <label for="sesto_imp_tra_file">tra file/gradoni (m)</label>
            <input id="sesto_imp_tra_file" name="sesto_imp_tra_file" value="<?php echo $b1->getData('sesto_imp_tra_file');?>">
        </div>
        <div id="sesto_imp_su_file_container">
            <label for="sesto_imp_su_file">sulla fila/gradone (m)</label>
            <input id="sesto_imp_su_file" name="sesto_imp_su_file" value="<?php echo $b1->getData('sesto_imp_su_file');?>">
        </div>
        <div id="buche_container">
            <label for="buche">buche (n/ha)</label>
            <input id="buche" name="buche" value="<?php echo $b1->getData('buche');?>">
        </div>
        </fieldset>
        <fieldset id="srcontainer" >
        <legend>Strato arbustivo: diffusione</legend>
        <?php
        foreach($b1->getControl('sr')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('sr'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sr" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="sr_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="arbustivecontainer" >
        <legend>Specie significative strato arbustivo</legend>
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
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editarbustive&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_arbustive">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'arbustive.php');?>
        </fieldset>
         <fieldset id="secontainer" >
        <legend>Strato erbaceo: diffusione</legend>
        <?php
        foreach($b1->getControl('se')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('se'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="se" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="se_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="erbaceecontainer" >
        <legend>Specie significative strato erbaceo</legend>
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
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editerbacee&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_erbacee">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'erbacee.php');?>
        </fieldset>
             <fieldset id="n1container" >
        <legend>Novellame</legend>
        <?php
        foreach($b1->getControl('n1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('n1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="n1_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n1arrow_right"></fieldset>
        <fieldset id="n2container" >
        <?php
        foreach($b1->getControl('n2')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('n2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n2" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="n2_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n3container" >
        <legend>Rinnovazione</legend>
        <?php
        foreach($b1->getControl('n3')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('n3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n3" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="n3_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n3arrow_right"></fieldset>
        <div id="spe_nov_container">
            <label for="spe_nov">Specie prevalente rinnovazione</label>
            <?php 
            $rennovationspecie = $b1->getRennovationSpecie();
            $value = '';
            if ($b1->getData('spe_nov') != '')
                $value = $rennovationspecie->getData('nome_itali').' | '.$rennovationspecie->getData('nome_scien');
            ?>
            <input type="hidden" id="spe_nov" name="spe_nov" value="<?php echo $b1->getData('spe_nov');?>"/>
            <input id="spe_nov_descr" name="spe_nov_descr" value="<?php echo $value; ?>" data-old-value="<?php echo $value; ?>">
        </div>
        <div id="int2_container">
            <label for="int2">Interventi recenti</label>
            <select id="int2" name="int2">
                <option value="">Scegli un intervento</option>
                <?php
                foreach($b1->getControl('int2')->getItems() as $item) :
                $selected = '';
                if ($item->getRawData('codice') == $b1->getData('int2'))
                    $selected = 'selected="selected"';
                ?>
                <option <?php echo $selected; ?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div id="int3_container">
            <label for="int3">Specifiche</label>
            <input id="int3" name="int3" value="<?php echo $b1->getData('int3');?>">
        </div>
        <div id="f_container">
            <label for="f">Funzione</label>
                <select id="f" name="f">
                <option value="">Scegli una funzione</option>
                <?php
                foreach($b1->getControl('f')->getItems() as $item) :
                $selected = '';
                if ($item->getRawData('codice') == $b1->getData('f'))
                    $selected = 'selected="selected"';
                ?>
                <option <?php echo $selected; ?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <fieldset id="gcontainer" >
        <legend>Orientamento selvicolturale</legend>
        <span >
            <div>
        <?php
        foreach($b1->getControl('g')->getItems() as $key=>$item) :
        if ($key/4 == intval($key/4) && $key > 0) :?>
            </div>
        </span><br style="clear:both;" />
        <span>
            <div>
        <?php
        endif;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('g'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="g" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
            </div>
        </span>
        </fieldset>
        <div id="p2_container">
            <label for="p2">Ipotesi di intervento futuro</label>
                <select id="p2" name="p2">
                <option value="">Scegli una'intervento</option>
                <?php
                foreach($b1->getControl('p2')->getItems() as $item) :
                $selected = '';
                if ($item->getRawData('codice') == $b1->getData('p2'))
                    $selected = 'selected="selected"';
                ?>
                <option <?php echo $selected; ?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div id="p3_container">
            <label for="p3">Ipotesi di intervento futuro (secondaria)</label>
                <select id="p3" name="p3">
                <option value="">Scegli una'intervento</option>
                <?php
                foreach($b1->getControl('p3')->getItems() as $item) :
                $selected = '';
                if ($item->getRawData('codice') == $b1->getData('p3'))
                    $selected = 'selected="selected"';
                ?>
                <option <?php echo $selected; ?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div id="p4_container">
            <label class="double" for="p4">Specifiche</label>
            <input id="p4" name="p4" value="<?php echo $b1->getData('p4');?>">
        </div>
        <fieldset id="g1container" >
        <legend>Priorità e condizionamenti</legend>
        <?php
        foreach($b1->getControl('g1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('g1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="g1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="g1_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        <div id="g1arrow_right"></div>
        <span class="spacer_descr">&nbsp;</span>
        <div id="sub_viab_container">
        <label  for="sub_viab">subordinato alla viabilità</label>
        <?php
        foreach($b1->getControl('sub_viab')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('sub_viab'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sub_viab" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="sub_viab_descr"><?php echo $item->getData('descriz'); ?></span>
        
        <?php endforeach;?>
        </div>
        </fieldset>
        <h4 id="label_dendro_1">Dati di orientamento dendrometrico</h4>
        <h4 id="label_dendro_2">Latifoglie</h4>
        <div id="d1_container">
            <label for="d1">Diametro preval. (cm)</label>
            <input id="d1" name="d1" value="<?php echo $b1->getData('d1');?>">
        </div>
        <div id="d3_container">
            <label for="d3">Altezza preval. (m)</label>
            <input id="d3" name="d3" value="<?php echo $b1->getData('d3');?>">
        </div>
        <div id="d5_container">
            <label for="d5">n° alberi/ha</label>
            <input id="d5" name="d5" value="<?php echo $b1->getData('d5');?>">
        </div>
        <h4 id="label_dendro_3">Conifere</h4>
        <div id="d14_container">
            <label for="d14">Diametro preval. (cm)</label>
            <input id="d14" name="d14" value="<?php echo $b1->getData('d14');?>">
        </div>
        <div id="d15_container">
            <label for="d15">Altezza preval. (m)</label>
            <input id="d15" name="d15" value="<?php echo $b1->getData('d15');?>">
        </div>
        <div id="d16_container">
            <label for="d16">n° alberi/ha</label>
            <input id="d16" name="d16" value="<?php echo $b1->getData('d16');?>">
        </div>
        </fieldset>
        <fieldset id="d_spec_container" >
            <legend>Altre stime sintetiche ricavate esternamente a <?php echo $GLOBALS['SITE_NAME']; ?> (richieste da Regione Lombardia)</legend>
        <div id="d21_container">
            <label for="d21">Provvigione reale (m3/ha)</label>
            <input id="d21" name="d21" value="<?php echo $b1->getData('d21');?>">
        </div>
        <div id="d22_container">
            <label for="d22">Provvigione reale (m3)</label>
            <input id="d22" name="d22" value="<?php echo $b1->getData('d22');?>">
        </div>
        <div id="d23_container">
            <label for="d23">Incremento corrente (m3/ha)</label>
            <input id="d23" name="d23" value="<?php echo $b1->getData('d23');?>">
        </div>
        <div id="d24_container">
            <label for="d24">Incremento corrente (m3)</label>
            <input id="d24" name="d24" value="<?php echo $b1->getData('d24');?>">
        </div>
        <div id="d26_container">
            <label for="d26">Classe di feracità stimata</label>
            <input id="d26" name="d26" value="<?php echo $b1->getData('d26');?>">
        </div>
        <div id="d25_container">
            <label for="d25">Provvigione normale (m3/ha)</label>
            <input id="d25" name="d25" value="<?php echo $b1->getData('d25');?>">
        </div>
        <div id="newdspecieexitimation">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>% Specie</div>
                    </span>
                    <span>
                        <div>Massa totale</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu_d" name="cod_coltu_d" value=""/>
                <input id="cod_coltu_d_descr" name="cod_coltu_d_descr" value=""/>
            </span>
            <span>
                <select id="cod_coper_d" name="cod_coper_d">
                    <option value="">Scegli un valore di copertura</option>
                    <?php
                    $forestmassesteem = new \forest\attribute\ForestMassEsteem();
                    $cod_coper_coll= $forestmassesteem->getControl('cod_coper');
                    foreach($cod_coper_coll->getItems() as $item) : ?>
                    <option value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                    <?php endforeach;?>
                </select>
            </span>
            <span>
                <input id="massa_tot" name="massa_tot" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editdesteem&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_dspecieexitimation">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una stima di massa legnosa"/>
                </a>
            </span>
            </div>
            <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'dspecieexitimation.php');?>
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
                    <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editnote&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_note">
                        <img class="actions addnew" src="images/empty.png" title="Aggiungi una nota"/>
                    </a>
                </span>
            </div>
        </div>
        <?php
        require __DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'note.php';
        ?>
        </fieldset>
        <fieldset id="forestnotecontainer">
            <legend>Note</legend>
            <textarea id="note" name="note" rows="16" cols="106"><?php echo $b1->getData('note');?></textarea>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb1.js" defer="defer"></script>
</div>