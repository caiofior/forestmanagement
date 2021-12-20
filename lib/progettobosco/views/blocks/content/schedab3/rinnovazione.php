<div id="content_schedab3_rinnovazione">
    <?php
    if (!isset($b3)) {
        $b3 = new \forest\entity\b\B3();
        $b3->loadFromId($_REQUEST['id']);
    }
    $b3renovationcomposition = new \forest\attribute\B3RenovationComposition();
    $cod_coper_coll = $b3renovationcomposition->getControl('cod_coper');
    $b3renovationcompositioncoll = $b3->getRenovationCompositionColl();
    
    
    if (!key_exists('start', $_GET))
        $_GET['start']=0;
    $items_in_page =2;
    
    $b3renovationcompositioncoll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));
    foreach ($b3renovationcompositioncoll->getItems() as $b3renovationcomposition) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_coltur_<?php echo $b3renovationcomposition->getData('objectid');?>" name="cod_coltur_<?php echo $b3renovationcomposition->getData('objectid');?>" value="<?php echo $b3renovationcomposition->getRawData('cod_coltu');?>"/>
                <input class="cod_coltu" id="cod_coltur_descr_<?php echo $b3renovationcomposition->getData('objectid');?>" data-arboree-id="<?php echo $b3renovationcomposition->getData('objectid');?>" name="cod_coltur_descr_<?php echo $b3renovationcomposition->getData('objectid');?>" value="<?php echo $b3renovationcomposition->getRawData('cod_colt_descriz');?>" data-old-value="<?php echo $b3renovationcomposition->getRawData('cod_colt_descriz');?>"/>
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;amp;id=<?php echo $b3->getData('objectid');?>&amp;amp;deleterinnovazione=<?php echo $b3renovationcomposition->getData('objectid');?>"  >
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
    $countall =$b3renovationcompositioncoll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&amp;amp;start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedab3_rinnovazione"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&amp;amp;start=0"',
            'data-update'=>'data-update="content_schedab3_rinnovazione"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&amp;amp;start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedab3_rinnovazione"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&amp;amp;start='.$last_page .'"',
            'data-update'=>'data-update="content_schedab3_rinnovazione"'
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
    