                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a></div>
<?php $profile = $this->user->getProfile(); ?>					
				<div class="post">
			
					<h2>Dati personali</h2>
					
                                        	<form action="<?php echo $GLOBALS['BASE_URL'];?>profile.php" method="post" id="profile_form">		
                                                        <div class="form_messages profile_messages" style="display: none;"></div>
                                                        <p >	
								<label for="first_name">Nome</label>
								<input class="large" id="first_name" name="first_name" value="<?php echo $profile->getData('first_name');?>" type="text" tabindex="1" />
							</p>
                                                        <p >	
								<label for="last_name">Cognome</label>
								<input class="large" id="last_name" name="last_name" value="<?php echo $profile->getData('last_name');?>" type="text" tabindex="2" />
							</p>
                                                        <p >	
								<label for="organization">Organizzazione</label>
								<input class="large" id="organization" name="organization" value="<?php echo $profile->getData('organization');?>" type="text" tabindex="3" />
							</p>
                                                        <p >	
								<label for="phone">Telefono</label>
								<input class="large" id="phone" name="phone" value="<?php echo $profile->getData('phone');?>" type="text" tabindex="4" />
							</p>			
                                                        <p >	
								<label for="web">Web</label>
								<input class="large" id="web" name="web" value="<?php echo $profile->getData('web');?>" type="text" tabindex="5" />
							</p>			
                                                        <p >	
								<label for="facebook">Facebook</label>
								<input class="large" id="facebook" name="facebook" value="<?php echo $profile->getData('facebook');?>" type="text" tabindex="6" />
							</p>			
                                                        <p >	
								<label for="google">Google</label>
								<input class="large" id="google" name="google" value="<?php echo $profile->getData('google');?>" type="text" tabindex="7" />
							</p>			
                                                        <p >	
								<label for="address_address">Via</label>
								<input id="address_address" name="address_address" value="<?php echo $profile->getData('address_address');?>" type="text" tabindex="8" />

								<label class="small" for="address_street_number">Numero civico</label>
								<input class="small" id="address_street_number" name="address_street_number" value="<?php echo $profile->getData('address_street_number');?>" type="text" tabindex="9" />
							</p>			
                                                        <p >	
								<label for="address_city">Città</label>
								<input id="address_city" name="address_city" value="<?php echo $profile->getData('address_city');?>" type="text" tabindex="10" />
								<label class="small" for="address_province">Prov.</label>
								<input class="small" id="address_province" name="address_province" value="<?php echo $profile->getData('address_province');?>" type="text" tabindex="11" />
								<label class="small" for="address_zip">CAP</label>
								<input class="small" id="address_zip" name="address_zip" value="<?php echo $profile->getData('address_zip');?>" type="text" tabindex="12" />
							</p>			

							<p class="no-border">
								<input class="button" name="profile" type="submit" value="Aggiorna" tabindex="13" />         		
							</p>
					
						</form>	
				<!-- /post -->	
				</div>	
                            

                           
			<!-- /main -->	
			</div>
