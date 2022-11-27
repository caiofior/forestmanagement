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
                                    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
                                   integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
                                   crossorigin=""></script>
                                   <script src='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.js'></script>
                                   <link href='https://api.mapbox.com/mapbox-gl-js/v0.46.0/mapbox-gl.css' rel='stylesheet' />
                                    <script type="text/javascript" src="js/bosco_cartografia.js" defer="defer"></script>
                                    </div>
                                    </div>
				<!-- /post -->	
				</div>	

			<!-- /main -->	
			</div>
