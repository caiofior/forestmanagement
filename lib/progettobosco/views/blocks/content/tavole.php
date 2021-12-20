                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post">
					<h2>Tavole di cubatura</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>tavole.php?" method="post" id="tavole_list">
                                        <div class="form_messages tavole_messages" style="display: none;"></div>
                                        <p>Seleziona una tavola.</p>
                                        <p>
                                        <label for="tipo">Tipo</label>
                                        <select class="large" id="tipo" name="tipo"  tabindex="1" >
                                            <option value="">Filtra per tipo</option>
                                            <?php
                                            $tabletypecoll = new \forest\attribute\TableTypeColl();
                                            $tabletypecoll->loadAll();
                                            foreach($tabletypecoll->getItems() as $tabletype) : ?>
                                            <option value="<?php echo $tabletype->getData('codice'); ?>"><?php echo $tabletype->getData('tipo_tavola'); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </p>
                                        <p >	
                                            <label for="search">Cerca</label>
                                            <input class="large float_width" id="search" name="search" type="text" tabindex="2" />
                                        </p>
                                        
                                        </form>	
                                        <?php require __DIR__.DIRECTORY_SEPARATOR.'tavole'.DIRECTORY_SEPARATOR.'list.php';?>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>