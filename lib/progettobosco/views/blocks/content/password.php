                        <!-- main -->
			<div id="main">	
<?php $profile = $this->user->getProfile(); ?>					
				<div class="post">
			
					<h2>Modifica password</h2>
					
                                        	<form action="<?php echo $GLOBALS['BASE_URL'];?>profile.php?action=password" method="post" id="profile_form">		
                                                        <div class="form_messages profile_messages" style="display: none;"></div>
							<p >	
								<label for="old_password">Vecchia password</label>
								<input class="large" id="old_password" class="required" name="old_password"  type="password" tabindex="1" />
							</p>
							<p >	
								<label for="new_password">Nuova password</label>
								<input class="large" id="new_password" class="required" name="new_password"  type="password" tabindex="2" />
							</p>
							<p >	
								<label for="confirm_password">Conferma password</label>
								<input class="large" id="confirm_password" class="required" name="confirm_password"  type="password" tabindex="3" />
							</p>

							<p class="no-border">
								<input class="button" name="modify_password" type="submit" value="Aggiorna" tabindex="4" />         		
							</p>
					
						</form>	
				<!-- /post -->	
				</div>	
                            

                            <!--
<div id='home'>

  
  
  <a class='main_button' id='edp' href='<?php echo $GLOBALS['BASE_URL'];?>descrp.php''>Elaborazione descrizioni particellari</a>

  <a class='main_button' id='tavole' href='<?php echo $GLOBALS['BASE_URL'];?>tavole.php'>Tavole di cubatura</a>

  <a class='main_button' id='descrp' href='<?php echo $GLOBALS['BASE_URL'];?>descrp.php'>Descrizioni particellari</a>

  <a class='main_button' id='comprese' href='?'>Comprese/Classi colturali</a>

  <a class='main_button' id='dizionari' href='<?php echo $GLOBALS['BASE_URL'];?>dizionari.php'>Dizionari</a>

  <a class='main_button' id='daticat' href='<?php echo $GLOBALS['BASE_URL'];?>daticat.php'>Dati catastali</a>

  <a class='main_button' id='spazio' href='?'></a>

  <a class='main_button' id='strumenti' href='?'>Strumenti</a>

  <a class='main_button' id='rildend' href='<?php echo $GLOBALS['BASE_URL'];?>rildend.php'>Rilievi dendrometrici</a>

  <a class='main_button' id='elabdp' href='?'>Elaborazione dati dendrometrici</a>

  <a class='main_button' id='gsta' href='?'>Gestione stampe</a>

  <a class='main_button' id='viab' href='<?php echo $GLOBALS['BASE_URL'];?>viabilita.php'>Descrizioni viabilità</a>

  <a class='main_button' id='piano' href='?'>Piano degli interventi</a>

  <a class='main_button' id='decod' href='?'>Decodifica schede</a>

</div>
                            -->
			<!-- /main -->	
			</div>
