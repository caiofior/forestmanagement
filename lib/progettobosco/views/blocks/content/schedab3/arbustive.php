<div id="content_schedab3_arbustive">
    <?php
    if (!isset($b3)) {
        $b3 = new \forest\entity\b\B3();
        $b3->loadFromId($_REQUEST['id']);
    }
    $shrubcompositioncoll = $b3->getShrubCompositionColl();
    
    if (!key_exists('start', $_GET))
            $_GET['start']=0;
    $items_in_page =2;
    
    $shrubcompositioncoll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));

    foreach ($shrubcompositioncoll->getItems() as $shrubcomposition) :
    ?>
    <div>
        <span>
            <div>
                <input readonly="readonly" id="cod_coltu_ar_descr_<?php echo $shrubcomposition->getData('objectid');?>" data-arbustive-id="<?php echo $shrubcomposition->getData('objectid');?>" name="cod_coltu_ar_descr_<?php echo $shrubcomposition->getData('objectid');?>" value="<?php echo $shrubcomposition->getRawData('cod_colt_descriz');?>" data-old-value="<?php echo $shrubcomposition->getRawData('cod_colt_descriz');?>"/>
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;id=<?php echo $b3->getData('objectid');?>&amp;deletearbustive=<?php echo $shrubcomposition->getData('objectid');?>"  >
                    <img class="actions delete" src="images/empty.png" title="Cancella"/>
                </a>
            </div>
        </span>
    </div>
    <?php endforeach; 
    
    $start = $_GET['start'];
    unset($_GET['start']);
    unset($_GET['task']);
    unset($_GET['action']);
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
    $countall =$shrubcompositioncoll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedab3_arbustive"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&amp;start=0"',
            'data-update'=>'data-update="content_schedab3_arbustive"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedab3_arbustive"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.$last_page .'"',
            'data-update'=>'data-update="content_schedab3_arbustive"'
        );
    }
    ?>
    <div class="scrollcontrols">
        <span>
        <a <?php echo $actions['first']['url'];?> <?php echo $actions['first']['data-update'];?> >
            <img class="actions first" src="images/empty.png" title="Primo">
        </a>
        <a <?php echo $actions['prev']['url'];?> <?php echo $actions['prev']['data-update'];?> >
            <img class="actions prev" src="images/empty.png" title="Precedente">
        </a>
        </span>
        <span>
            Specie <input id="current" name="current" value="<?php echo $start; ?>" type="text"  /> di <?php echo $countall; ?></span>
        <a href="#" style="display: none;" id="confirm_move">
            <img class="actions confirm" src="images/empty.png" title="Vai">
        </a>
        <a href="#" style="display: none;" id="cancel_move">
            <img class="actions cancel" src="images/empty.png" title="Annulla">
        </a>
        </span>
        <span>
        <a <?php echo $actions['next']['url'];?> <?php echo $actions['next']['data-update'];?> >
            <img class="actions next" src="images/empty.png" title="Successivo">
        </a>
        <a <?php echo $actions['last']['url'];?> <?php echo $actions['last']['data-update'];?> >
            <img class="actions last" src="images/empty.png" title="Ultimo">
        </a>
        </span>
    </div>
</div>
    