                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a></div>
				<div class="post">
					<h2>Boschi</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?<?php echo http_build_query($_GET);?>" method="post" id="forest_list">		
                                                        <p>Filtra le foreste per regione e denominazione.</p>
                                                        	
								<label for="regione">Regione</label>
                                                                <select id="regione" name="regione"  tabindex="1" >
                                                                    <option value="">Italia</option>
                                                                    <?php 
                                                                        $forestcoll = $this->user->getForestColl(!$this->user->isAdmin()); 
                                                                        $regioncoll = $forestcoll->getRegionColl();
                                                                        foreach($regioncoll->getItems() as $region) : ?>
                                                                    <option value="<?php echo $region->getData('codice');?>"><?php echo $region->getData('descriz');?></option>        
                                                                    <?php endforeach; ?>
                                                                </select>

								<label for="descrizion_search">Denominazione</label>
								<input class="large float_width" id="descrizion_search" name="descrizion_search" value="" type="text" tabindex="2" />
                                                        <?php 
                                                        require __DIR__.DIRECTORY_SEPARATOR.'bosco'.DIRECTORY_SEPARATOR.'forestlist.php'; 
                                                        ?>
                                        
                                        </form>	
	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
