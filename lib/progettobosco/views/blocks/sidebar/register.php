                                                <div class="sidemenu" id="sidebar_login">
                                                <h3>Registrati</h3>				
			
						<form action="<?php echo $GLOBALS['BASE_URL'];?>" method="post" id="login_form">		
                                                        <div class="form_messages login_messages" style="display: none;"></div>
                                                        <p class="no-border"> Iscriviti per integrare le tue conoscenze con la rete
                                                            dei tecnici forestali italiani.
                                                        </p>
							<p >	
								<label for="username">Nome utente (email)</label><br />
								<input id="username" class="required" name="username" value="" type="text" tabindex="1" />
							</p>
			
							<p>
								<label for="password">password</label><br />
								<input id="password" class="required" name="password" value="" type="password" tabindex="2" />
							</p>
                                                        
                                                        <p>
								<label for="confirm_password">Conferma password</label><br />
								<input id="confirm_password" class="required" name="confirm_password" value="" type="password" tabindex="3" />
							</p>

                                                        <p>
								<label for="message">Interessi professionali</label><br />
								<textarea id="message" name="message" rows="10" cols="20" tabindex="4"></textarea>
                                                                In poche parole che cosa ti aspetti da questo progetto.
							</p>	

			
							<p class="no-border">
								<input class="button" name="register" type="submit" value="Registrati" tabindex="5" />         		
                                                                <a href="#" data-update="sidebar_login">Accedi</a> o <a href="#" class="password_recover">recupera la password</a>
							</p>
					
						</form>	
                                                <?php require __DIR__.DIRECTORY_SEPARATOR.'recoverpassword.php';  ?>
                                                </div>