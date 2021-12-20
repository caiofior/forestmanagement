<div id="content_schedab2_arboree">
    <?php
    if (!isset($b2)) {
        $b2 = new \forest\entity\b\B2();
        $b2->loadFromId($_REQUEST['id']);
    }
    $corkcovercomposition = new \forest\attribute\covercomposition\B2();
    $cod_coper_coll = $corkcovercomposition->getControl('cod_coper');
    $corkcovercompositioncoll = $b2->getCoverCompositionColl();
    
    
    if (!key_exists('start', $_GET))
        $_GET['start']=0;
    $items_in_page =2;
    
    $corkcovercompositioncoll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));
    foreach ($corkcovercompositioncoll->getItems() as $corkcovercomposition) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_coltu_<?php echo $corkcovercomposition->getData('objectid');?>" name="cod_coltu_<?php echo $corkcovercomposition->getData('objectid');?>" value="<?php echo $corkcovercomposition->getRawData('cod_coltu');?>"/>
                <input class="cod_coltu" id="cod_coltu_descr_<?php echo $corkcovercomposition->getData('objectid');?>" data-arboree-id="<?php echo $corkcovercomposition->getData('objectid');?>" name="cod_coltu_descr_<?php echo $corkcovercomposition->getData('objectid');?>" value="<?php echo $corkcovercomposition->getRawData('cod_colt_descriz');?>" data-old-value="<?php echo $corkcovercomposition->getRawData('cod_colt_descriz');?>"/>
            </div>
        </span>
        <span>
            <div>
                <input id="cod_coper_<?php echo $corkcovercomposition->getData('objectid');?>" name="cod_coper_<?php echo $corkcovercomposition->getData('objectid');?>" data-arboree-id="<?php echo $corkcovercomposition->getData('objectid');?>" value="<?php echo $corkcovercomposition->getData('cod_coper');?>" />
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&amp;id=<?php echo $b2->getData('objectid');?>&amp;deletearboree=<?php echo $corkcovercomposition->getData('objectid');?>"  >
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
    $countall =$corkcovercompositioncoll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedab2_arboree"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&amp;start=0"',
            'data-update'=>'data-update="content_schedab2_arboree"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedab2_arboree"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.$last_page .'"',
            'data-update'=>'data-update="content_schedab2_arboree"'
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
    