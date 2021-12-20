<div id="content_schedab4_arboree">
    <?php
    if (!isset($b4)) {
        $b4 = new \forest\entity\b\B4();
        $b4->loadFromId($_REQUEST['id']);
    }
    $b4covercomposition = new \forest\attribute\covercomposition\B3();
    $cod_coper_coll = $b4covercomposition->getControl('cod_coper');
    $b4covercompositioncoll = $b4->getCoverCompositionColl();
    
    
    if (!key_exists('start', $_GET))
        $_GET['start']=0;
    $items_in_page =2;
    
    $b4covercompositioncoll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));
    foreach ($b4covercompositioncoll->getItems() as $b4covercomposition) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_coltu_<?php echo $b4covercomposition->getData('objectid');?>" name="cod_coltu_<?php echo $b4covercomposition->getData('objectid');?>" value="<?php echo $b4covercomposition->getRawData('cod_coltu');?>"/>
                <input class="cod_coltu" id="cod_coltu_descr_<?php echo $b4covercomposition->getData('objectid');?>" data-arboree-id="<?php echo $b4covercomposition->getData('objectid');?>" name="cod_coltu_descr_<?php echo $b4covercomposition->getData('objectid');?>" value="<?php echo $b4covercomposition->getRawData('cod_colt_descriz');?>" data-old-value="<?php echo $b4covercomposition->getRawData('cod_colt_descriz');?>"/>
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&amp;id=<?php echo $b4->getData('objectid');?>&amp;deletearboree=<?php echo $b4covercomposition->getData('objectid');?>"  >
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
    $countall =$b4covercompositioncoll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedab4_arboree"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&amp;start=0"',
            'data-update'=>'data-update="content_schedab4_arboree"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedab4_arboree"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.$last_page .'"',
            'data-update'=>'data-update="content_schedab4_arboree"'
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
    