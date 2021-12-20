			<!-- sidebar -->
			<div id="sidebar">
							
                        <div class="sidemenu">
					
 				<h3><?php echo $this->user->getData('username'); ?></h3>				
					<ul>
						<li><a href="<?php echo $GLOBALS['BASE_URL'];?>?logout=1">Esci</a></li>
                                                <?php if(is_numeric($this->user->getData('id'))):?>
                                                <li><a href="<?php echo $GLOBALS['BASE_URL'];?>profile.php">Dati personali</a></li>
                                                <li><a href="<?php echo $GLOBALS['BASE_URL'];?>profile.php?action=password">Password</a></li>
                                                <li><a id="remove_profile" href="<?php echo $GLOBALS['BASE_URL'];?>profile.php?action=remove">Rimuovi profilo</a></li>
                                                <?php endif; ?>
					</ul>
					
				</div>

				
				
			<!-- /sidebar -->				
			</div>
