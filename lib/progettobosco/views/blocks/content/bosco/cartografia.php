<?php
                        if (!isset($forest))
                            $forest = $this->forest;
                            $poligoncoll = $forest->getPoligonColl();
                            $centroid = $poligoncoll->getCentroid();
?>                     <!-- main -->
			<div id="main">	
                            <div id="breadcrumb">
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco Boschi</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $forest->getData('codice');?>">Elenco Particelle</a>
                            </div>
				<div class="post">
                                    <script type="text/javascript">
                                        var center = {
                                        lat : <?php echo $centroid->Lat();?>,
                                        long : <?php echo $centroid->Long();?>,
                                        id_av : "<?php echo $GLOBALS['BASE_URL'].'kml.php?table=geo_particellare&forest_id='.$forest->getData('codice'); ?>"
                                        };
                                    </script>
                                    <div id="forestcompartmentmaincontent">
                                    <script type="text/javascript" >
                                    document.getElementById("tabrelatedcss").href="css/cartografia.css";
                                    </script>
                                    <div id="tabContent">
                                    <div id="map-canvas"></div>
                                    <script type="text/javascript" src="js/bosco_cartografia.js" defer="defer"></script>
                                    </div>
                                    </div>
				<!-- /post -->	
				</div>	

			<!-- /main -->	
			</div>
