                                                        <div id="content_userManageForestlist" >       
                                                        <ul >
                                                            <?php 
                                                                if (!key_exists('filter', $_GET))
                                                                    $_GET['filter']=null;
                                                                if (!isset($forestcoll))
                                                                    $forestcoll = $user_detail->getForestColl($_GET['filter']=='checked'); 
                                                                else 
                                                                    $user_detail = $this->user_detail;
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('regione', $_GET))
                                                                    $_GET['regione']=null;
                                                                unset($_GET['owned_by']);
                                                                unset($_GET['notowned_by']);
                                                                unset($_GET['editowned_by']);
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
                                                                <?php 
                                                               if(
                                                                        is_array($forest->getRawData('write_users')) &&
                                                                        in_array($user_detail->getData('id'), $forest->getRawData('write_users'))
                                                                   ) : ?>
                                                                <a href="?<?php echo http_build_query($_GET);?>&forest_id=<?php echo $forest->getData('codice');?>&notowned_by=<?php echo $user_detail->getData('id');?>" data-update="content_userManageForestlist">
                                                                <img class="actions editowned" src="images/empty.png" title="Assegnato - scrittura"/>
                                                                </a>
                                                                <?php elseif(
                                                                        is_array($forest->getRawData('read_users')) &&
                                                                        in_array($user_detail->getData('id'), $forest->getRawData('read_users'))
                                                                   ) : ?>
                                                                <a href="?<?php echo http_build_query($_GET);?>&forest_id=<?php echo $forest->getData('codice');?>&editowned_by=<?php echo $user_detail->getData('id');?>" data-update="content_userManageForestlist">
                                                                <img class="actions owned" src="images/empty.png" title="Assegnato - lettura"/>
                                                                </a>
                                                                <?php else : ?>
                                                                <a href="?<?php echo http_build_query($_GET);?>&forest_id=<?php echo $forest->getData('codice');?>&owned_by=<?php echo $user_detail->getData('id');?>" data-update="content_userManageForestlist">
                                                                <img class="actions notowned" src="images/empty.png" title="Non assegnato"/>
                                                                </a>
                                                                <?php endif;
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
                                                                'data-update'=>'data-update="content_userManageForestlist"'
                                                            );
                                                            $actions['first']=array(
                                                                'url'=>'href="?'.$baseurl.'&start=0"',
                                                                'data-update'=>'data-update="content_userManageForestlist"'
                                                            );
                                                        }
                                                                                                               
                                                        if ($start<$last_page) {
                                                             
                                                             $actions['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
                                                                'data-update'=>'data-update="content_userManageForestlist"'
                                                            );
                                                             $actions['last']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.$last_page.'"',
                                                                'data-update'=>'data-update="content_userManageForestlist"'
                                                            );
                                                        }
                                                        ?>
                                                        <div id="scrollcontrols">
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
                                                        </div>
                                                        </div>
