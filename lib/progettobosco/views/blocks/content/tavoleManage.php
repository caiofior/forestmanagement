<!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>tavole.php">Tavole di cubatura</a></div>
				<div class="post">
					<h2>Tavola: <?php echo $this->table->getData('descriz');?></h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>tavole.php?<?php echo http_build_query($_GET);?>" method="post" id="tavola">		
                                        <fieldset id="general">
                                        <div id="codice_container">
                                            <label for="codice">Codice</label>
                                            <input id="codice" name="codice" value="<?php echo $this->table->getData('codice');?>"/>
                                        </div>
                                        <div id="descriz_container">
                                            <label for="descriz">Descrizione</label>
                                            <input id="descriz" name="descriz" value="<?php echo $this->table->getData('descriz');?>"/>
                                        </div>
                                        <div id="autore_container">
                                            <label for="autore">Autore e anno</label>
                                            <input id="autore" name="autore" value="<?php echo $this->table->getData('autore');?>"/>
                                        </div>
                                        <div id="note_container">
                                            <label for="note">Note</label>
                                            <textarea id="note" name="note" rows="5" cols="15"><?php echo $this->table->getData('note');?></textarea>
                                        </div>
                                            <fieldset id="tipo_container">
                                                <legend>Tipo</legend>    
                                                <?php
                                                $tabletypecoll = new \forest\attribute\TableTypeColl();
                                                $tabletypecoll->loadAll();
                                                foreach($tabletypecoll->getItems() as $tabletype) : 
                                                $checked = '';
                                                if ($tabletype->getData('codice') ==$this->table->getData('tipo'))
                                                        $checked = 'checked="checked"';
                                                ?>
                                                <input type="checkbox" <?php echo $checked;?> name="tipo" value="<?php echo $tabletype->getData('codice');?>"/>
                                                <?php echo $tabletype->getData('tipo_tavola');?><br/>
                                                <?php endforeach; ?>
                                            </fieldset>
                                            <fieldset id="forma_container">
                                                <legend>Forma</legend>    
                                                <?php
                                                $formacoll = array(
                                                    1=>'Tabellare',
                                                    2=>'Funzione',
                                                );
                                                foreach($formacoll as $key=>$value) : 
                                                $checked = '';
                                                if ($key ==$this->table->getData('forma'))
                                                        $checked = 'checked="checked"';
                                                ?>
                                                <input type="checkbox" <?php echo $checked;?> name="forma" value="<?php echo $key;?>"/>
                                                <?php echo $value;?><br/>
                                                <?php endforeach; ?>
                                            </fieldset>
                                            <div id="biomassa_container">
                                                <label for="biomassa"><span>Modello prev. biomassa</span></label>
                                                <input type="checkbox" name="biomassa" id="biomassa" <?php echo ( $tabletype->getData('biomassa') =='f'? '': 'checked="checked"' ) ;?> value="1"/>
                                            </div>
                                            <div id="assortimenti_container">
                                                <label for="assortimenti">Assortimentale</label>
                                                <input name="assortimenti" id="assortimenti" type="checkbox" <?php echo ( $tabletype->getData('assortimenti') =='f'? '': 'checked="checked"' ) ;?> value="1"/>
                                            </div>
                                            <div id="n_tariffa_container">
                                                <label for="n_tariffa">N° tariffe</label>
                                                <input id="n_tariffa" name="n_tariffa" value="<?php echo $this->table->getData('n_tariffa');?>"/>
                                            </div>
                                            <div>Campi di variazione</div>
                                            <fieldset id="var1_container">
                                                <div>Diametri cm</div>
                                                <div id="d_min_container">
                                                    <label for="d_min">min</label>
                                                    <input id="d_min" name="d_min" value="<?php echo $this->table->getData('d_min');?>"/>
                                                </div>
                                                <div id="d_max_container">
                                                    <label for="d_max">max</label>
                                                    <input id="d_max" name="d_max" value="<?php echo $this->table->getData('d_max');?>"/>
                                                </div>
                                                <div id="classe_d_container">
                                                    <label for="classe_d">Ampiezza classe</label>
                                                    <input id="classe_d" name="classe_d" value="<?php echo $this->table->getData('classe_d');?>"/>
                                                </div>
                                            </fieldset>
                                            <fieldset id="var2_container" >                                       
                                                <div >Altezze m</div>
                                                <div id="h_min_container">
                                                    <label for="h_min">min</label>
                                                    <input id="h_min" name="h_min" value="<?php echo $this->table->getData('h_min');?>"/>
                                                </div>
                                                <div id="h_max_container">
                                                    <label for="h_max">max</label>
                                                    <input id="h_max" name="h_max" value="<?php echo $this->table->getData('h_max');?>"/>
                                                </div>
                                                <div id="classe_h_container">
                                                    <label for="classe_h">Ampiezza classe</label>
                                                    <input id="classe_h" name="classe_h" value="<?php echo $this->table->getData('classe_h');?>"/>
                                                </div>
                                            </fieldset>
                                            <div id="funzione_container">
                                                <label for="funzione">Funzione</label>
                                                <textarea id="funzione" name="funzione" rows="10" cols="30"><?php echo $this->table->getData('funzione');?></textarea>
                                            </div>
                                        </fieldset>
                                        <?php $table5 = $this->table->getTable5(); 
                                        if( !$table5->isEmpty()) : ?>
                                        <fieldset id="assortimenti_selector_container">
                                            <legend>Scegliere gli assortimenti descritti nella tavola di cubatura:</legend>
                                            <?php
                                            foreach($table5->getFields() as $field): 
                                                if ($field['intesta'] != ''):
                                                $checked ='';
                                                if ($table5->getData($field['nomecampo']) == 't')
                                                    $checked ='checked="checked"';
                                            ?>
                                            <input type="radio" <?php echo $checked; ?> name="table5"/><?php echo $field['intesta']; ?><br/>
                                            <?php 
                                                endif;
                                            endforeach; ?>
                                        </fieldset>
                                        <?php endif; ?>
                                        <?php $table4 = $this->table->getTable4();
                                        if( !$table4->isEmpty() ) : ?>
                                        <fieldset id="funzioni_assortimenti_selector_container">
                                            <legend>Inserire il testo delle funzioni relative a ciascun assortimento:</legend>
                                            <?php
                                            foreach($table4->getFields() as $field): 
                                                if (
                                                        $field['intesta'] != '' && 
                                                        $field['nomecampo'] != 'pf' &&
                                                        $field['nomecampo'] != 'ps'
                                                        ):
                                             ?>
                                            
                                            <input name="table4_<?php $field['nomecampo'];?>" value="<?php echo $table4->getData($field['nomecampo']); ?>"/><?php echo $field['intesta']; ?><br/>
                                            <?php 
                                                endif;
                                            endforeach; ?>
                                        </fieldset>
                                        <fieldset id="funzioni_biomassa_selector_container">
                                            <legend>Inserire il testo delle funzioni :</legend>
                                            <?php
                                            foreach($table4->getFields() as $field): 
                                                if (
                                                        $field['intesta'] != '' && 
                                                        ($field['nomecampo'] == 'pf' ||
                                                        $field['nomecampo'] == 'ps')
                                                        ):
                                             ?>
                                            
                                            <input name="table4_<?php $field['nomecampo'];?>" value="<?php echo $table4->getData($field['nomecampo']); ?>"/><?php echo $field['intesta']; ?><br/>
                                            <?php 
                                                endif;
                                            endforeach; ?>
                                        </fieldset>
                                        <?php endif; ?>
                                            <fieldset>
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" data-codice="<?php echo $this->table->getData('codice');?>" id="table2" >
                                                    <thead>
                                                        <tr>
                                                            <th >Id</th>
                                                            <th >Tariffa</th>
                                                            <th >Diametro</th>
                                                            <th >Altezza</th>
                                                            <th >Volume</th>
                                                            <th> Azioni</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="24" class="dataTables_empty">Caricamento dei dati</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th >Id</th>
                                                            <th >Tariffa</th>
                                                            <th >Diametro</th>
                                                            <th >Altezza</th>
                                                            <th >Volume</th>
                                                            <th> Azioni</th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </fieldset>
                                        </form>	
	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
