                                                        <div id="content_bosco_forestlist" >       
                                                        <ul >
                                                            <?php 
                                                            
                                                                if (!key_exists('filter', $_GET))
                                                                        $_GET['filter'] = null;
                                                                if (!isset($forestcoll))
                                                                    $forestcoll = $user->getForestColl($user->isAdmin() == false || ($_GET['filter'] != null && $_GET['filter'] != 'checked'));
                                                                else
                                                                    $user = $this->user;
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('regione', $_GET))
                                                                    $_GET['regione']=null;
                                                                unset($_GET['delete']);
                                                                $items_in_page =10;
                                                                $forestcoll->loadAll(
                                                                        array(
                                                                    'start'=>$_GET['start'],
                                                                    'length'=>$items_in_page,
                                                                    'search'=>$_GET['search'],
                                                                    'regione'=>$_GET['regione']
                                                                )
                                                                );
                                                            foreach($forestcoll->getItems() as $forest) :
                                                            ?>
                                                            <li >
                                                                <a href="bosco.php?action=manage&id=<?php echo $forest->getData('codice'); ?>" >
                                                                <img class="actions edit" src="images/empty.png" title="Visualizza/Modifica"/>
                                                                </a>
                                                                <?php if ($user->isUserForestAdmin($forest)) : ?>
                                                                <a href="bosco.php?<?php echo http_build_query($_GET); ?>&delete=1&id=<?php echo $forest->getData('codice'); ?>" >
                                                                <img class="actions delete" src="images/empty.png" title="Cancella"/>
                                                                </a>
                                                                <?php endif; ?>
                                                                <?php
                                                                echo $forest->getData('descrizion');?>
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
                                                        $countall =$forestcoll->countAll(array('search'=>$_GET['search']));
                                                        $last_page = floor($countall/$items_in_page)*$items_in_page;

                                                        if ($start>0) {
                                                            $actions['prev']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
                                                                'data-update'=>'data-update="content_bosco_forestlist"'
                                                            );
                                                            $actions['first']=array(
                                                                'url'=>'href="?'.$baseurl.'&start=0"',
                                                                'data-update'=>'data-update="content_bosco_forestlist"'
                                                            );
                                                        }
                                                        
                                                        if ($start<$countall-$items_in_page) {
                                                            
                                                            $actions['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
                                                                'data-update'=>'data-update="content_bosco_forestlist"'
                                                            );
                                                             $actions['last']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
                                                                'data-update'=>'data-update="content_bosco_forestlist"'
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
                                                            <a href="bosco.php?action=manage" >
                                                                <img class="actions addnew" src="images/empty.png" title="Aggiungi una nuova foresta"/>
                                                            </a>
                                                        </div>
                                                        </div>
