                                                <div id="passwordrecover_container" style="display:none;">   
                                                <h3>Recupera la password</h3>
                                                            
                                                <form action="<?php echo $GLOBALS['BASE_URL'];?>" method="post" id="recoverpassword_form">		
                                                        <p>
                                                            Inserisci il tuo indirizzo di posta e ti sarà inviata una mail
                                                            con la nuova password.
							</p>
                                                        <div class="form_messages recoverpassword_messages" style="display: none;"></div>
							<p >	
								<label for="username">email</label><br />
								<input id="recover_username" class="required" name="username" value="" type="text" tabindex="1" />
							</p>
			
							<p class="no-border">
								<input class="button" name="recoverpassword" type="submit" value="Recupera" tabindex="2" />         		
							</p>
					
						</form>	
                                                </div>