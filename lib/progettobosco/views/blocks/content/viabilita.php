                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $this->forest->getData('codice');?>">Elenco Particelle</a></div>
				<div class="post" id="viabilita_main_content">
					<h2>Viabilità</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>viabilita.php?id=<?php echo $this->forest->getData('codice');?>" method="post" id="viabilita_list">
                                        <div class="form_messages viabilita_messages" style="display: none;"></div>
                                        <p>Seleziona una strada.</p>
                                        <p >	
                                            <label for="search">Cerca</label>
                                            <input class="large float_width" id="search" name="search" type="text" tabindex="2" />
                                        </p>
                                        
                                        </form>	
                                        <?php require __DIR__.DIRECTORY_SEPARATOR.'viabilita'.DIRECTORY_SEPARATOR.'list.php';?>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>