                        <!-- main -->
                        <?php
                        if (!isset($forest))
                            $forest=$this->forest;
                        ?>
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $this->forest->getData('codice');?>">Elenco Particelle</a></div>
				<div class="post" id="comprese_main_content">
					<h2>Comprese / Classi colturali</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>comprese.php?<?php echo http_build_query($_GET);?>" method="post" id="comprese_list">
                                            <p>
                                               Queste sono tutte le comprese del bosco.<br/>
                                               <span class="working_circle_not_selected">Seleziona una compresa per vedere e modificare le particelle che la compongono.</span>
                                            </p>
                                        <p>
                                        <input type="hidden" id="id" name="id" value="<?php echo $this->forest->getData('codice');?>" />
                                        <input type="hidden" id="sequence" name="sequence" value="0" />
                                        <input type="hidden" id="todo" name="todo" value="" />
                                        <label for="compresa">Compresa/Classe colturale</label>
                                        <select class="large" id="compresa" name="compresa"  tabindex="1" >
                                            <option value="">Seleziona una compresa</option>
                                            <?php 
                                                $compresacoll = $forest->getWorkingCircleColl();
                                                $compresacoll->loadAll();
                                                foreach($compresacoll->getItems() as $compresa) : ?>
                                            <option  value="<?php echo $compresa->getData('objectid');?>"><?php echo $compresa->getData('descrizion');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        <br/>
                                        <label for="search">Cerca</label>
                                        <input class="large" id="search" name="search"  tabindex="2" >
                                        <a id="add_filter" href="#">Aggiungi filtro</a>
                                        <div id="content_comprese_filter"></div>
                                        </form>
				<!-- /post -->	
				</div>
                                <?php require __DIR__.DIRECTORY_SEPARATOR.'comprese'.DIRECTORY_SEPARATOR.'list.php';?>
			<!-- /main -->	
			</div>