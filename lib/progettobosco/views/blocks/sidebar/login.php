			<!-- sidebar -->
			<div id="sidebar">
							
                        <div class="sidemenu" id="sidebar_register" >
					
 						<h3>Accedi</h3>				
			
						<form action="<?php echo $GLOBALS['BASE_URL'];?>" method="post" id="login_form">		
                                                        <div class="form_messages login_messages" style="display: none;"></div>
							<p >	
								<label for="username">Nome utente (email)</label><br />
								<input id="username" class="required" name="username" value="" type="text" tabindex="1" />
							</p>
			
							<p>
								<label for="password">password</label><br />
								<input id="password" class="required" name="password" value="" type="password" tabindex="2" />
							</p>
			
			
							<p class="no-border">
								<input class="button" name="login" type="submit" value="Accedi" tabindex="3" />         		
                                                                <a href="#" data-update="sidebar_register">registrati</a> o <a href="#" class="password_recover">recupera la password</a>
							</p>
					
						</form>	
                                                <?php require __DIR__.DIRECTORY_SEPARATOR.'recoverpassword.php'; ?>
					
				</div>

				
				
			<!-- /sidebar -->				
			</div>

