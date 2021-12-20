                                                        <?php
                                                        $compresa = new \forest\WorkingCircle();
                                                        if (!isset($forest))
                                                                    $forest = $this->forest;
                                                        if (
                                                                key_exists('compresa', $_REQUEST) &&
                                                                $_REQUEST['compresa'] != '')
                                                            $compresa->loadFromId ($_REQUEST['compresa']);    
                                                        try{
                                                            $forest = $compresa->getForest();
                                                        } catch (Exception $e) {
                                                            if ($e->getCode() != 0705131053)
                                                                throw $e;
                                                        }
                                                        ?>
                                                        <div id="content_comprese_listselected" >       
                                                            
                                                            <p>
                                                                Particelle associate alla compresa<br>
                                                                <span style="display: none;" class="working_circle_selected">Trascina qui le particelle che vuoi aggiungere alla compresa</span>
                                                                <a id="remove_all" class="working_circle_selected" href="#">Rimuovi tutte</a>
                                                            </p>
                                                        <ul >
                                                            <?php 
                                                                $acoll = $forest->getAColl();
                                                                $items_in_page =10;
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('parameter', $_GET))
                                                                    $_GET['parameter']=null;
                                                                if (!key_exists('operator', $_GET))
                                                                    $_GET['operator']=null;
                                                                if (!key_exists('value', $_GET))
                                                                    $_GET['value']=null;
                                                                $acoll->loadAll(
                                                                        array(
                                                                    'start'=>$_GET['start'],
                                                                    'length'=>$items_in_page,
                                                                    'search'=>$_GET['search'],
                                                                    'parameter'=>$_GET['parameter'],
                                                                    'operator'=>$_GET['operator'],
                                                                    'value'=>$_GET['value'],
                                                                    'associated_compresa'=>true
                                                                )
                                                                );
                                                            foreach($acoll->getItems() as $a) :
                                                            ?>
                                                            <li id="s<?php echo $a->getData('objectid');?>">
                                                                <?php echo $a->getData('cod_part');?> - 
                                                                <?php echo $a->getData('toponimo');?>
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
                                                            'parameter'=>$_GET['parameter'],
                                                            'operator'=>$_GET['operator'],
                                                            'value'=>$_GET['value'],
                                                            'associated_compresa'=>true)                                                            
                                                            
                                                        );
                                                        $last_page = floor($countall/$items_in_page)*$items_in_page;

                                                        if ($start>0) {
                                                            $actions['prev']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
                                                                'data-update'=>'data-update="content_rilievidendrometrici_list"'
                                                            );
                                                            $actions['first']=array(
                                                                'url'=>'href="?'.$baseurl.'&start=0"',
                                                                'data-update'=>'data-update="content_rilievidendrometrici_list"'
                                                            );
                                                        }
                                                        
                                                        if ($start<$countall-$items_in_page) {
                                                            
                                                            $actions['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
                                                                'data-update'=>'data-update="content_rilievidendrometrici_list"'
                                                            );
                                                             $actions['last']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
                                                                'data-update'=>'data-update="content_rilievidendrometrici_list"'
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
                                                            <a href="bosco.php?task=formx&action=manage&forma_id=<?php echo $compresa->getData('objectid');?>" data-update="content_rilievidendrometrici_edit" data-destination="content_rilievidendrometrici_list">
                                                                <img class="actions addnew" src="images/empty.png" title="Aggiungi un nuovo rilievo"/>
                                                            </a>
                                                        </div>
                                                        </div>
