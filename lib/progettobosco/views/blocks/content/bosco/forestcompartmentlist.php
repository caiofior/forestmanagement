                                                        <div id="content_bosco_forestcompartmentlist" >       
                                                        <ul >
                                                            <?php 
                                                                if (!isset($forest))
                                                                    $forest=$this->forest;
                                                                if (!isset($acoll))
                                                                    $acoll = $forest->getAColl();
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('usosuolo', $_GET))
                                                                    $_GET['usosuolo']=null;
                                                                if (!key_exists('t', $_GET))
                                                                    $_GET['t']=null;
                                                                if (!key_exists('codiope', $_GET))
                                                                    $_GET['codiope']=null;
                                                                unset($_GET['delete']);
                                                                $items_in_page =10;
                                                                $acoll->loadAll(
                                                                        array(
                                                                    'start'=>$_GET['start'],
                                                                    'length'=>$items_in_page,
                                                                    'search'=>$_GET['search'],
                                                                    'usosuolo'=>$_GET['usosuolo'],
                                                                    't'=>$_GET['t'],
                                                                    'codiope'=>$_GET['codiope']
                                                                )
                                                                );
                                                            foreach($acoll->getItems() as $a) :
                                                            ?>
                                                            <li >
                                                                <a href="bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid'); ?>" >
                                                                <img class="actions edit" src="images/empty.png" title="Visualizza/Modifica"/>
                                                                </a>
                                                                <a href="bosco.php?deleteforestcompartment=1&id=<?php echo $a->getData('objectid'); ?>" >
                                                                <img class="actions delete" src="images/empty.png" title="Cancella"/>
                                                                </a>
                                                                Particella <?php echo $a->getData('cod_part');?>
                                                                <?php $toponimo = $a->getData('toponimo');
                                                                if ($toponimo != '') echo ' - '.$toponimo;
                                                                $usosuolo = $a->getRaWData('usosuolo');
                                                                if ($usosuolo != '') echo '<br/>Uso suolo:'.$usosuolo;
                                                                $rilevato = $a->getRawData('rilevato');
                                                                if ($rilevato != '' ) echo '<br/>Rilevatore:'.$rilevato;?>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <?php
                                                        $start = $_GET['start'];
                                                        unset($_GET['start']);
                                                        $baseurl = http_build_query($_GET);
                                                        $actions =array(
                                                            'first'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'prev'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'next'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'last'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                        );
                                                        $countall =$acoll->countAll(array(
                                                                    'search'=>$_GET['search'],
                                                                    'usosuolo'=>$_GET['usosuolo'],
                                                                    'codiope'=>$_GET['codiope']
                                                                ));
                                                        $last_page = floor($countall/$items_in_page)*$items_in_page;

                                                        if ($start>0) {
                                                            $actions['prev']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
                                                                'data-update'=>'data-update="content_bosco_forestcompartmentlist"'
                                                            );
                                                            $actions['first']=array(
                                                                'url'=>'href="?'.$baseurl.'&start=0"',
                                                                'data-update'=>'data-update="content_bosco_forestcompartmentlist"'
                                                            );
                                                        }
                                                        
                                                        if ($start<$countall-$items_in_page) {
                                                            
                                                            $actions['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
                                                                'data-update'=>'data-update="content_bosco_forestcompartmentlist"'
                                                            );
                                                             $actions['last']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
                                                                'data-update'=>'data-update="content_bosco_forestcompartmentlist"'
                                                            );
                                                        }
                                                        ?>
                                                        <div class="scrollcontrols">
                                                            <a <?php echo $actions['first']['url'];?> <?php echo $actions['first']['data-update'];?> >
                                                                <img class="actions first" src="images/empty.png" title="Primo">
                                                            </a>
                                                            <a <?php echo $actions['prev']['url'];?> <?php echo $actions['prev']['data-update'];?> >
                                                                <img class="actions prev" src="images/empty.png" title="Precedente">
                                                            </a>
                                                                                                                        <span>Bosco <input id="current" name="current" value="<?php echo $start; ?>" type="text"  /> di <?php echo $countall; ?></span>
                                                            <a href="#" style="display: none;" id="confirm_move">
                                                                <img class="actions confirm" src="images/empty.png" title="Vai">
                                                            </a>
                                                            <a href="#" style="display: none;" id="cancel_move">
                                                                <img class="actions cancel" src="images/empty.png" title="Annulla">
                                                            </a>
                                                            <a <?php echo $actions['next']['url'];?> <?php echo $actions['next']['data-update'];?> >
                                                                <img class="actions next" src="images/empty.png" title="Successivo">
                                                            </a>
                                                            <a <?php echo $actions['last']['url'];?> <?php echo $actions['last']['data-update'];?> >
                                                                <img class="actions last" src="images/empty.png" title="Ultimo">
                                                            </a>
                                                            <a href="bosco.php?action=createforestcompartment&forest_codice=<?php echo $forest->getData('codice'); ?>" >
                                                                <img class="actions addnew" src="images/empty.png" title="Aggiungi una nuova particella"/>
                                                            </a>
                                                        </div>
                                                        </div>
