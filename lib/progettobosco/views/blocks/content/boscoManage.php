                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Modifica bosco</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage<?php echo (key_exists('id', $_REQUEST) ? '&id='.$_REQUEST['id'] : ''); ?>" method="post" id="manage_bosco">
                                        <div class="form_messages bosco_messages" style="display: none;"></div>
                                        <p>Per modificare o inserire un bosco è necessario indicare la regione 
                                            , la denominazione e un codice identificativo composto da lettere
                                            e numeri.</p>
                                        <p>
                                        <label for="regione">Regione</label>
                                        <select class="large" id="regione" name="regione"  tabindex="1" >
                                            <option value="">Seleziona la regione</option>
                                            <?php 
                                                $regioncoll = new \forest\RegionColl();
                                                $regioncoll->loadAll();
                                                foreach($regioncoll->getItems() as $region) : 
                                                    $selected = '';
                                                    if ($region->getData('codice') == $this->forest->getData('regione'))
                                                        $selected = 'selected="selected"';
                                                    ?>
                                            <option <?php echo $selected; ?> value="<?php echo $region->getData('codice');?>"><?php echo $region->getData('descriz');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        </p>
                                        <p >	
                                            <label for="descrizion">Descrizione</label>
                                            <input class="large float_width" id="descrizion" name="descrizion" value="<?php echo $this->forest->getData('descrizion');?>" type="text" tabindex="2" />
                                        </p>
                                        <p >	
                                            <label for="codice">Codice<span id="prefissocodice"><?php echo $this->forest->getData('regione'); ?></span></label>
                                            <input class="large float_width" id="codice" name="codice" value="<?php echo substr($this->forest->getData('codice'),2);?>" type="text" tabindex="3" />
                                        </p>
                                        <p class="no-border">
                                                <input class="float_width button" name="update" type="submit" value="Aggiorna" tabindex="4" />         		
                                        </p>
                                        <?php if ($this->forest->getData('codice') != '') : ?>
                                        <p class="no-border">
                                                <a class="button submit" href="<?php echo $GLOBALS['BASE_URL'];?>daticat.php?id=<?php echo $this->forest->getData('codice'); ?>">Dati Catastali</a>         		
                                        </p>
                                        <p class="no-border">
                                                <a class="button submit" href="<?php echo $GLOBALS['BASE_URL'];?>viabilita.php?id=<?php echo $this->forest->getData('codice'); ?>">Viabilità</a>         		
                                        </p>
                                        <p class="no-border">
                                                <a class="button submit" href="<?php echo $GLOBALS['BASE_URL'];?>comprese.php?id=<?php echo $this->forest->getData('codice'); ?>">Comprese/<br/>Classi colturali</a>         		
                                        </p>
                                        <p class="no-border">
                                                <a class="button submit" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=cartografia&id=<?php echo $this->forest->getData('codice'); ?>">Cartografia</a>         		
                                        </p>
                                        <?php endif; ?>
                                        </form>	
                                        <?php if ($this->forest->getData('codice') != '') : ?>
                                        <h2>Particelle forestali</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?forest_codice=<?php echo $this->forest->getData('codice');?>" method="post" id="forestcompartment_list">		
                                        <p>Questo è l'elenco delle particelle di questo bosco, puoi modificarle o
                                        aggiungerne di nuove.</p>
                                        <?php $acoll = $this->forest->getAColl(); ?>
								<label for="usosuolo">Uso suolo</label>
                                                                <select id="usosuolo" name="usosuolo"  tabindex="1" >
                                                                    <option value="">Tutti</option>
                                                                    <?php 
                                                                        $soilusecoll = $this->forest-> getAttributeColl(new \forest\attribute\SoilUseColl());
                                                                        $soilusecoll->loadAll();
                                                                        foreach($soilusecoll->getItems() as $soiluse) : ?>
                                                                    <option value="<?php echo $soiluse->getData('codice');?>"><?php echo $soiluse->getData('descriz');?></option>        
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <label for="codiope">Operatore</label>
                                                                <?php ?>
                                                                <select id="codiope" name="codiope"  tabindex="2" >
                                                                    <option value="">Tutti</option>
                                                                    <?php 
                                                                        $collectorcoll = $this->forest-> getAttributeColl(new \forest\attribute\CollectorColl());
                                                                        $collectorcoll->loadAll();
                                                                        foreach($collectorcoll->getItems() as $collector) : ?>
                                                                    <option value="<?php echo $collector->getData('codice');?>"><?php echo $collector->getData('descriz');?></option>        
                                                                    <?php endforeach; ?>
                                                                </select><br />

								<label for="search">Codice / Toponimo</label>
								<input class="large float_width" id="search" name="search" value="" type="text" tabindex="3" />
                                                        <?php 
                                                        $_GET['forest_codice']=$this->forest->getData('codice');
                                                        require __DIR__.DIRECTORY_SEPARATOR.'bosco'.DIRECTORY_SEPARATOR.'forestcompartmentlist.php'; 
                                                        ?>
                                        
                                        </form>	

                                        <?php endif; ?>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
