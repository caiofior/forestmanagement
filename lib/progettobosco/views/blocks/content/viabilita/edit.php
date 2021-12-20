<?php
if (!isset($user))
    $user = $this->user;
if (!isset($forest))
    $forest = $this->forest;
    $e = $forest->getEColl()->getFirst();
if (
        key_exists('e_id', $_REQUEST) && 
        $_REQUEST['e_id'] != ''
        )
    $e-> loadFromId($_REQUEST['e_id']);
?>
                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post" id="viabilita_main_content">
					<h2>Viabilità</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>viabilita.php?id=<?php echo $forest->getData('codice');?>" method="post" id="viabilita_list">
                                        <div class="form_messages viabilita_messages" style="display: none;"></div>
                                         <fieldset id="general">
                                            <input type="hidden" id="id" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
                                            <input type="hidden" id="e_id" name="objectid" value="<?php echo $e->getData('objectid');?>"/>
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
                                                <input type="hidden" id="codiope" name="codiope" value="<?php echo $e->getData('codiope');?>"/>
                                                <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $e->getCollector()->getData('descriz');?>"/>
                                            </div>
                                            <div id="data_container">
                                                <label for="data">Data</label>
                                                <input id="data" name="data" value="<?php echo $e->getData('data');?>">
                                            </div>
                                            <p id="note1">Scheda E per la descrizione della VIABILITA' FORESTALE E RURALE</p>
                                            <div id="lung_gis_container">
                                                <label for="lung_gis">Lunghezza (m)</label>
                                                <input id="lung_gis" name="lung_gis" value="<?php echo $e->getData('lung_gis');?>"/>
                                            </div>
                                            <div id="strada_container">
                                                <label for="strada">Percorso n°</label>
                                                <input id="strada" name="strada" value="<?php echo $e->getData('strada');?>"/>
                                            </div>
                                            <div id="nome_strada_container">
                                                <label for="nome_strada">Nome percorso</label>
                                                <input id="nome_strada" name="nome_strada" value="<?php echo $e->getData('nome_strada');?>"/>
                                            </div>
                                            <div id="da_valle_container">
                                                <label for="da_valle">Punto di partenza (a valle)</label>
                                                <input id="da_valle" name="da_valle" value="<?php echo $e->getData('da_valle');?>"/>
                                            </div>
                                            <div id="a_monte_container">
                                                <label for="a_monte">Punto di arrivo (a monte)</label>
                                                <input id="a_monte" name="a_monte" value="<?php echo $e->getData('a_monte');?>"/>
                                            </div>
                                            <fieldset id="class_amm_container" >
                                                <legend>Classificazione amministrativa</legend>
                                                <?php
                                                foreach($e->getControl('class_amm')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('class_amm'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="class_amm" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php if ($key/3 == intval($key/3) && $key > 0 ) :?>
                                                <br/>
                                                <?php endif; ?>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="class_prop_container" >
                                                <legend>Classificazione proposta</legend>
                                                <?php
                                                foreach($e->getControl('class_prop')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('class_prop'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="class_prop" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php if (($key+1)/3 == intval(($key+1)/3) && $key > 0 ) :?>
                                                <br/>
                                                <?php endif; ?>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="qual_att_container" >
                                                <legend>Classificazione tecnica attuale</legend>
                                                <?php
                                                foreach($e->getControl('qual_att')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('qual_att'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="qual_att" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php if (($key+1)/4 == intval(($key+1)/4) && $key > 0 ) :?>
                                                <br/>
                                                <?php endif; ?>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="qual_prop_container" >
                                                <legend>Classificazione tecnica proposta</legend>
                                                <?php
                                                foreach($e->getControl('qual_prop')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('qual_prop'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="qual_prop" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php if (($key+1)/4 == intval(($key+1)/4) && $key > 0 ) :?>
                                                <br/>
                                                <?php endif; ?>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset>
                                            <label>Larghezza (m)</label>
                                            <div id="larg_min_container">
                                                <input id="larg_min" name="larg_min" value="<?php echo $e->getData('larg_min');?>"/>
                                                <label for="larg_min">minima</label>
                                            </div>
                                            <div id="larg_prev_container">
                                                <input id="larg_prev" name="larg_prev" value="<?php echo $e->getData('larg_prev');?>"/>
                                                <label for="larg_prev">prevalente</label>
                                            </div>
                                            <div id="raggio_curve_container">
                                                <label for="raggio_curve">Raggio minimo curve</label>
                                                <input id="raggio_curve" name="raggio_curve" value="<?php echo $e->getData('raggio_curve');?>"/>
                                            </div>
                                            <fieldset id="fondo_container" >
                                                <legend>Fondo</legend>
                                                <?php
                                                foreach($e->getControl('fondo')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('fondo'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="fondo" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <label>Pendenza %</label>
                                            <div id="pend_media_container">
                                                <input id="pend_media" name="pend_media" value="<?php echo $e->getData('pend_media');?>"/>
                                                <label for="pend_media">media</label>
                                            </div>
                                            <div id="pend_max_container">
                                                <input id="pend_max" name="pend_max" value="<?php echo $e->getData('pend_max');?>"/>
                                                <label for="pend_max">massima</label>
                                            </div>
                                            <div id="contropend_container">
                                                <label for="contropend">Contropendenza %</label>
                                                <input id="contropend" name="contropend" value="<?php echo $e->getData('contropend');?>"/>
                                            </div>
                                            <fieldset id="q_piazzole_container" >
                                                <legend>Piazzole di scambio</legend>
                                                <?php
                                                foreach($e->getControl('q_piazzole')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('q_piazzole'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="q_piazzole" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php endforeach;?>
                                            </fieldset>
                                            </fieldset>
                                            <fieldset id="accesso_container" >
                                                <legend>Accesso</legend>
                                                <?php
                                                foreach($e->getControl('accesso')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('accesso'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="accesso" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="transitabi_container" >
                                                <legend>Transitabilità</legend>
                                                <?php
                                                foreach($e->getControl('transitabi')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('transitabi'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="transitabi" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="manutenzione_container" >
                                                <legend>Manutenzione e miglioramenti previsti</legend>
                                                <?php
                                                foreach($e->getControl('manutenzione')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('manutenzione'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="manutenzione" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php if (($key+1)/3 == intval(($key+1)/3) && $key > 0 ) :?>
                                                <br/>
                                                <?php endif; ?>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="urgenza_container" >
                                                <legend>Priorità</legend>
                                                <?php
                                                foreach($e->getControl('urgenza')->getItems() as $key=>$item) :
                                                $checked = '';
                                                if ($item->getRawData('codice') == $e->getData('urgenza'))
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="radio" name="urgenza" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"/><span><?php echo $item->getData('descriz'); ?></span>
                                                <?php endforeach;?>
                                            </fieldset>
                                            <fieldset id="interventi_container" >
                                                <legend>Interventi</legend>
                                                <?php
                                                $fields = $e->getFields();
                                                $fields = array_filter($fields, create_function('$val', 'return $val["tipo"]=="l";'));
                                                unset($fields['scarpate']);
                                                usort($fields, create_function('$a, $b', ' 
                                                    if ($a["ordine"] == $b["ordine"]) return 0;
                                                return ($a["ordine"] < $b["ordine"]) ? -1 : 1;'));
                                                unset($fields['scarpate']);
                                                foreach($fields as $key=>$item) :
                                                $checked = '';
                                                if ($e->getData($item['nomecampo']) == 1)
                                                    $checked = 'checked="checked"';
                                                ?>
                                                <input type="checkbox" id="<?php echo $item['nomecampo']; ?>" name="<?php echo $item['nomecampo']; ?>" <?php echo $checked; ?> /><span><?php echo $item['intesta']; ?></span>
                                                <?php if (($key+1)/3 == intval(($key+1)/3) && $key > 0 ) :?>
                                                <br/>
                                                <?php endif; ?>
                                                <?php endforeach;?>
                                                <div id="specifica_container">
                                                    <label for="specifica">Specifica</label>
                                                    <input id="specifica" name="specifica" value="<?php echo $e->getData('specifica');?>"/>
                                                </div>
                                            </fieldset>
                                         </fieldset>
                                        <fieldset id="e1_container">
                                        <legend>Interventi localizzati</legend>
                                        <div id="newe1">
                                                <div>
                                                    <span>
                                                        <div>Codice</div>
                                                    </span>
                                                    <span>
                                                        <div>Descrizione</div>
                                                    </span>
                                                    <span>
                                                        <div>Azioni</div>
                                                    </span>
                                                </div>
                                            <div>
                                                <span>
                                                    <input type="hidden" id="cod_inter" name="cod_inter" value=""/>
                                                    <input id="cod_inter_descr" name="cod_inter_descr" value=""/>
                                                </span>

                                                <span>
                                                    <input id="descrzione" name="descrzione" value=""/>
                                                </span>
                                                <span>
                                                    <a href="<?php echo $GLOBALS['BASE_URL'];?>viabilita.php?ction=edite1&amp;id=<?php echo $e->getData('objectid');?>" data-update="content_viabilita_e1">
                                                        <img class="actions addnew" src="images/empty.png" title="Aggiungi un'intervento"/>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <?php
                                        require __DIR__.DIRECTORY_SEPARATOR.'e1.php';
                                        ?>
                                        </fieldset>
                                        <fieldset id="forestnotecontainer">
                                            <legend>Note</legend>
                                            <textarea id="note" name="note" rows="16" cols="45"><?php echo $e->getData('note');?></textarea>
                                        </fieldset>
                                        </form>	
                                        
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>