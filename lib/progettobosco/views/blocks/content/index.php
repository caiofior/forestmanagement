			<!-- main -->
			<div id="main">	
					
				<div class="post">
			
					<h2>Benvenuto</h2>
					
                                        <p>Puoi aggiungere i dati di un bosco, modificarne uno
                                        già esistente o aggiornare i tuoi dati personali</p>
				        <ul class="index_menu">
                                            <?php if ($this->user->isAdmin()) :?>
                                            <li><a class="user_admin" href='<?php echo $GLOBALS['BASE_URL'];?>user.php'>Amministra utenti</a></li>
                                            <?php endif; ?>
                                            <li><a class="bosco" href='<?php echo $GLOBALS['BASE_URL'];?>bosco.php'>Bosco</a></li>
                                            <li><a class="cubatura" href='<?php echo $GLOBALS['BASE_URL'];?>tavole.php'>Tavole di cubatura</a></li>
                                        </ul>
				<!-- /post -->	
				</div>	
                            

                           
			</div>
