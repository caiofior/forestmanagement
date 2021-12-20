<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b4 = $b->getB4Coll()->getFirst();
?>
<div id="forestcompartmentmaincontent">
    <script type="text/javascript" >
        document.getElementById("tabrelatedcss").href = "css/formb4.css";
    </script>
    <div id="tabContent">
        <form id="formB4" action="<?php echo $GLOBALS['BASE_URL']; ?>bosco.php?task=formb4&amp;action=update&amp;id=<?php echo $a->getData('objectid'); ?>">
            <div class="form_messages formb4_errors" style="display: none;"></div>
                <a class="deleteTab" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid');?>" alt="Cancella Scheda">
                        <img class="actions delete" src="images/empty.png" title="Cancella"/>
                        Cancella scheda
                </a>
                <fieldset id="general">
                <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice'); ?>"/>
                <input type="hidden" id="objectid" name="objectid" value="<?php echo $b4->getData('objectid'); ?>"/>
                <div id="regione_container">
                    <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz'); ?><br/>
                        Sistema informativo per l'assestamento forestale</p>     
                </div>
                <div id="bosco_container">
                    <label for="bosco">Bosco</label>
                    <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion'); ?>"/>
                </div>
                <div id="note_1">
                    <h3 >Schede B4 per descrivere una formazione a macchia mediterranea</h3>
                </div>
                <div id="cod_part_container">
                    <label  for="cod_part">Particella / sottoparticella</label>
                    <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part'); ?>"/>
                </div>
                <div id="t_container">
                    <label for="t" >Tipo forestale</label>
                    <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t'); ?>"/>
                    <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz'); ?>"/>
                </div>
                <fieldset id="ucontainer" >
                    <legend>Tipo</legend>
                    <div>
                        <?php
                        $labels = array(
                            13 => 'formazione a macchia mediterranea'
                        );
                        foreach ($labels as $key => $item) :
                            $checked = '';
                            if ($key == $b->getData('u'))
                                $checked = 'checked="checked"';
                            ?>
                            <input type="checkbox" name="u" <?php echo $checked; ?> value="<?php echo $key; ?>"/><span><?php echo $item; ?></span>
                        <?php endforeach; ?>
                    </div>
                </fieldset>
            </fieldset>
            <fieldset id="specific_data">
                <fieldset id="vert_container" >
                    <legend>Struttura verticale</legend>
                    <?php
                    foreach ($b4->getControl('vert')->getItems() as $item) :
                        $checked = '';
                        if ($item->getRawData('codice') == $b4->getData('vert'))
                            $checked = 'checked="checked"';
                        ?>
                        <input type="radio" name="vert" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                    <?php endforeach; ?>
                </fieldset>
                <p id="note_2">Piano Dominato oppure strato sino a 2M di altezza</p>
                <div id="ce_min2_container">
                    <label for="ce_min2">Copertura (%)</label>
                    <input id="ce_min2" name="ce_min2" value="<?php echo $b4->getData('ce_min2');?>"/>
                </div>
                <div id="h_min2_container">
                    <label for="h_min2">Altezza media</label>
                    <input id="h_min2" name="h_min2" value="<?php echo $b4->getData('h_min2');?>"/>
                </div>
                    <fieldset id="arbustivecontainer" >
                        <legend><span>Composizione strato arboreo - arbustiva</span></legend>
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
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb4&amp;action=editarbustive&amp;id=<?php echo $b4->getData('objectid');?>" data-update="content_schedab4_arbustive">
                                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
                                </a>
                            </span>
                            </div>
                        </div>
                        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab4'.DIRECTORY_SEPARATOR.'arbustive.php');?>
                    </fieldset>
                <p id="note_3">Piano Dominante oppure strato oltre i 2M di altezza</p>
                <div id="ce_mag2_container">
                    <label for="ce_mag2">Copertura (%)</label>
                    <input id="ce_mag2" name="ce_mag2" value="<?php echo $b4->getData('ce_mag2');?>"/>
                </div>
                <div id="h_mag2_container">
                    <label for="h_mag2">Altezza media</label>
                    <input id="h_mag2" name="h_mag2" value="<?php echo $b4->getData('h_mag2');?>"/>
                </div>
                    <fieldset id="arboreecontainer" >
                        <legend>Composizione strato arboreo - arbustiva</legend>
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
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb4&amp;action=editarboree&amp;id=<?php echo $b4->getData('objectid');?>" data-update="content_schedab4_arboree">
                                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie"/>
                                </a>
                            </span>
                            </div>
                        </div>
                        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab4'.DIRECTORY_SEPARATOR.'arboree.php');?>
                    </fieldset>
                    <fieldset id="motivo1_container" >
                        <legend>Motivo che ha determinato e/o determina l’esistenza della macchia mediterranea</legend>
                        <?php
                        foreach($b4->getControl('motivo1')->getItems() as $item) :
                        $checked = '';
                        if ($item->getRawData('codice') == $b4->getData('motivo1'))
                            $checked = 'checked="checked"';
                        ?>
                        <input type="radio" name="motivo1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                        <?php endforeach;?>
                        <span id="motivo2_container">
                            <input id="motivo2" name="motivo2" value="<?php echo $b4->getData('motivo2');?>"/>
                        </span>
                    </fieldset>
                    <fieldset id="erbaceecontainer" >
                        <legend><span>Specie erbacee significative</span></legend>
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
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb4&amp;action=editerbacee&amp;id=<?php echo $b4->getData('objectid');?>" data-update="content_schedab3_erbacee">
                                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                                </a>
                            </span>
                            </div>
                        </div>
                        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab4'.DIRECTORY_SEPARATOR.'erbacee.php');?>
                        </fieldset>
                        <fieldset id="se_container" >
                            <legend>Strato erbaceo</legend>
                            <?php
                            foreach($b4->getControl('se')->getItems() as $item) :
                            $checked = '';
                            if ($item->getRawData('codice') == $b4->getData('se'))
                                $checked = 'checked="checked"';
                            ?>
                            <input type="radio" name="se" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span><br/>
                            <?php endforeach;?>
                        </fieldset>
                        <div id="int2_container">
                            <label for="int2">Interventi recenti</label>
                            <select id="int2" name="int2">
                                <option value="">Scegli un'intervento</option>
                                <?php
                                foreach($b4->getControl('int2', create_function('$item', 'return strpos($item->getData("schede"),"b4") !== false; '))->getItems() as $item) : ?>
                                <option <?php echo ($item->getData('codice') == $b4->getData('int2') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div id="int3_container">
                            <label for="int3">Specifiche</label>
                            <input id="int3" name="int3" value="<?php echo $b4->getData('int3');?>"/>
                        </div>
                        <div id="f_container">
                            <label for="f">Funzione</label>
                            <select id="f" name="f">
                                <option value="">Scegli un'intervento</option>
                                <?php
                                foreach($b4->getControl('f')->getItems() as $item) : ?>
                                <option <?php echo ($item->getData('codice') == $b4->getData('f') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <fieldset id="g_container" >
                            <legend>Orientamento colturale</legend>
                            <?php
                            foreach($b4->getControl('g')->getItems() as $key=>$item) :
                            $checked = '';
                            if ($item->getRawData('codice') == $b4->getData('g'))
                                $checked = 'checked="checked"';
                            ?>
                            <input type="radio" name="g" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                            <?php if (($key+1)/4 == intval(($key+1)/4)) :?>
                            <br style="clear: both;"/>
                            <?php endif;?>
                            <?php endforeach;?>
                        </fieldset>
                        <div id="p2_container">
                            <label for="p2">Ipotesi di intervento futuro</label>
                            <select id="p2" name="p2">
                                <option value="">Scegli un'intervento</option>
                                <?php
                                foreach($b4->getControl('p2',create_function('$item', 'return strpos($item->getData("schede"),"b4") !== false; '))->getItems() as $item) : ?>
                                <option <?php echo ($item->getData('codice') == $b4->getData('p2') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div id="p3_container">
                            <label for="p3">Ipotesi di intervento futuro (secondaria)</label>
                            <select id="p3" name="p3">
                                <option value="">Scegli un'intervento</option>
                                <?php
                                foreach($b4->getControl('p3',create_function('$item', 'return strpos($item->getData("schede"),"b4") !== false; '))->getItems() as $item) : ?>
                                <option <?php echo ($item->getData('codice') == $b4->getData('p3') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <div id="p4_container">
                            <label for="p4">Specifiche</label>
                            <input id="p4" name="p4" value="<?php echo $b4->getData('p4');?>"/>
                        </div>
                        <fieldset id="g1_container" >
                            <legend>Priorità e condizionamenti</legend>
                            <?php
                            foreach($b4->getControl('g1')->getItems() as $key=>$item) :
                            $checked = '';
                            if ($item->getRawData('codice') == $b4->getData('g1'))
                                $checked = 'checked="checked"';
                            ?>
                            <input type="radio" name="g1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                            <?php endforeach;?>
                            <fieldset id="g1arrow_right"></fieldset>
                            <fieldset id="sub_viab_container" >
                            <legend>Subordinato alla viabilità</legend>
                            <?php
                            foreach($b4->getControl('sub_viab')->getItems() as $key=>$item) :
                            $checked = '';
                            if ($item->getRawData('codice') == $b4->getData('sub_viab'))
                                $checked = 'checked="checked"';
                            ?>
                            <input type="radio" name="sub_viab" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                            <?php endforeach;?>
                            </fieldset>
                        </fieldset>
                        <fieldset id="forestnotecontainer">
                            <legend>Note</legend>
                            <textarea id="note" name="note" rows="5" cols="90"><?php echo $b4->getData('note');?></textarea>
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
                                        <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;action=editnote&amp;id=<?php echo $b4->getData('objectid');?>" data-update="content_schedab4_note">
                                            <img class="actions addnew" src="images/empty.png" title="Aggiungi una nota"/>
                                        </a>
                                    </span>
                                </div>
                            </div>
                            <?php
                            require __DIR__.DIRECTORY_SEPARATOR.'schedab4'.DIRECTORY_SEPARATOR.'note.php';
                            ?>
                            </fieldset>
            </fieldset>
        </form>
    </div>
    <script type="text/javascript" src="js/formb4.js" defer="defer"></script>
</div>