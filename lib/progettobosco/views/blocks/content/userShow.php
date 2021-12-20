                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>user.php">Utenti</a></div>
				<div class="post">
                                    <?php $profile = $this->user_detail->getProfile(); ?>
					<h2>Dettaglio utente</h2>
                                        <table>
                                            <thead>
                                                <tr>	
                                                <th>Variabile</th>
                                                <th>Valore</th>
                                                </tr>
                                                
                                            </thead>
                                            <tbody>
                                                        <tr>	
							<td>Nome utente</td>
								<td><?php echo $this->user_detail->getData('username');?></td>
							</tr>
                                                        <tr>	
								<td>Nome</td>
								<td><?php echo $profile->getData('first_name');?></td>
							</tr>
                                                        <tr >	
								<td >Cognome</td>
								<td><?php echo $profile->getData('last_name');?></td>
							</tr>
                                                        <tr >	
								<td >Organizzazione</td>
								<td ><?php echo $profile->getData('organization');?></td>
							</tr>
                                                        <tr >	
								<td >Email</td>
								<td ><?php echo $profile->getData('email');?></td>
							</tr>
                                                        <tr >	
								<td >Telefono</td>
								<td ><?php echo $profile->getData('phone');?></td>
							</tr>			
                                                        <tr >	
								<td >Web</td>
								<td ><?php echo $profile->getData('web');?></td>
							</tr>			
                                                        <tr>	
								<td >Facebook</td>
								<td ><?php echo $profile->getData('facebook');?></td>
							</tr>			
                                                        <tr >	
								<td >Google</td>
								<td ><?php echo $profile->getData('google');?> </td>
							</tr>			
                                                        <tr >	
								<td>Via</td>
								<td><?php echo $profile->getData('address_address');?>
								<?php echo $profile->getData('address_street_number');?></td>
							</tr>			
                                                        <tr >	
								<td >Città</td>
                                                                <td ><?php echo $profile->getData('address_city');?>
                                                                <?php if ($profile->getData('address_province') != '') :?>
								(<?php echo $profile->getData('address_province');?>)
                                                                <?php endif; ?>
								<?php echo $profile->getData('address_zip');?></tr>
							</tr>			
                                                        <tr >	
								<td >Creato il</td>
								<td > <?php 
                                                                    $date = $this->user_detail->getData('creation_datetime');
                                                                    if ($date != '') :
                                                                       $date = new DateTime($date);
                                                                       echo $date->format('Y-m-d H:i');
                                                                    endif;
                                                                    ?> </td>
							</tr>
                                                        <tr >	
								<td >Ultimo accesso il</td>
								<td ><?php 
                                                                    $date = $this->user_detail->getData('lastlogin_datetime');
                                                                    if ($date != '') :
                                                                       $date = new DateTime($date);
                                                                       echo $date->format('Y-m-d H:i');
                                                                    endif;
                                                                    ?> </td>
							</tr>	
                                                        <tr >	
								<td >Messaggio</td>
								<td ><?php echo  $this->user_detail->getData('message'); ?> </td>
							</tr>
                                                        </tbody>                                           
                                            </table>
					
                                        	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
