                        <?php
                        $a = $this->a;
                        $forest = $a->getForest();
                        $tabs = $a->getBForms();
                        ?>
                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb">
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco Boschi</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $forest->getData('codice');?>">Elenco Particelle</a>
                            </div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Particella</h2>
                                        <p>I dati delle particelle forestali sono raccolti in
                                        sei schede di rilevamento.</p>
                                        <div id="formtab">
                                            <span class="active"><a data-update="content_particellaSchedaA" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda A</a></span><?php if (in_array('b1', $tabs)) :?><!--
                                         --><span><a data-update="content_particellaSchedaB1" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda B1</a></span><?php endif; if (in_array('b2', $tabs)) :?><!--
                                         --><span><a data-update="content_particellaSchedaB2" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda B2</a></span><?php endif; if (in_array('b3', $tabs)) :?><!--
                                         --><span><a data-update="content_particellaSchedaB3" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda B3</a></span><?php endif; if (in_array('b4', $tabs)) :?><!--
                                         --><span><a data-update="content_particellaSchedaB4" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda B4</a></span><?php endif; ?>
                                            <br />
                                            <span><a data-update="content_particellaSchedaN" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda N</a></span><!--
                                        --><span><a data-update="content_particellaRilieviDendrometrici" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Rilievi dendrometrici</a></span><!--
                                        --><span><a data-update="content_particellaDescrizione" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Descrizione</a></span><!--
                                        --><span><a data-update="content_particellaCartografia" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Cartografia</a>
                                        </div>
                                        <?php require __DIR__.DIRECTORY_SEPARATOR.'particellaSchedaA.php';?>
				<!-- /post -->	
				</div>	

			<!-- /main -->	
			</div>
