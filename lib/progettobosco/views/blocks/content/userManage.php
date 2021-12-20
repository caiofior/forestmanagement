                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>user.php">Utenti</a></div>
				<div class="post">
                                    <?php $profile = $this->user_detail->getProfile(); ?>
					<h2>Boschi associati all'utente <?php echo $this->user_detail->getData('username');?></h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>user.php?<?php echo http_build_query($_GET);?>" method="post" id="forest_list">		
                                                        <p>Filtra le foreste per regione e denominazione.</p>
                                                        	<label for="regione">Regione</label>
                                                                <select id="regione" name="regione"  tabindex="1" >
                                                                    <option value="">Italia</option>
                                                                    <?php 
                                                                        $forestcoll = $this->user_detail->getForestColl(true); 
                                                                        $regioncoll = $forestcoll->getRegionColl();
                                                                        foreach($regioncoll->getItems() as $region) : ?>
                                                                    <option value="<?php echo $region->getData('codice');?>"><?php echo $region->getData('descriz');?></option>        
                                                                    <?php endforeach; ?>
                                                                </select>

								<label for="descrizion">Denominazione</label>
								<input class="large" id="descrizion" name="descrizion" value="" type="text" tabindex="2" /> <br />
                                                                <label for="filter_owned" >Solo i boschi gestiti</label>
                                                                <input type="checkbox" id="filter_owned" name="filter_owned" checked="checked" />
                                                        <?php 
                                                        require __DIR__.DIRECTORY_SEPARATOR.'userManageForestlist.php'; 
                                                        ?>
                                        </form>	
                                        	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
