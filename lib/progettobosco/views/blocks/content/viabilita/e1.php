<div id="content_viabilita_e1">

    <?php
    if (!isset($e)) {
        $e = new \forest\entity\e\E();
        $e->loadFromId($_REQUEST['id']);
    }
    $e1coll = $e->getE1Coll();
    if (!key_exists('start', $_GET))
            $_GET['start']=0;
    $items_in_page =2;
    
    $e1coll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));
    foreach ($e1coll->getItems() as $e1) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_inter_<?php echo $e1->getData('objectid');?>" name="cod_inter_<?php echo $e1->getData('objectid');?>" value="<?php echo $e1->getRawData('cod_inter');?>"/>
                <input class="cod_inter" id="cod_inter_descr_<?php echo $e1->getData('objectid');?>" data-e1-id="<?php echo $e1->getData('objectid');?>" name="cod_inter_descr_<?php echo $e1->getData('objectid');?>" value="<?php echo $e1->getRawData('cod_inter_descr');?>" data-old-value="<?php echo $e1->getRawData('nota_descr');?>"/>
            </div>
        </span>
        <span>
            <div>
                <input id="descrzione_<?php echo $e1->getData('objectid');?>" name="descrzione_<?php echo $e1->getData('objectid');?>" data-e1-id="<?php echo $e1->getData('objectid');?>" value="<?php echo $e1->getData('descrizione');?>" />
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>viabilita.php?id=<?php echo $e->getData('objectid');?>&amp;deletee1=<?php echo $e1->getData('objectid');?>"  >
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
    $countall =$e1coll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_viabilita_e1"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&amp;start=0"',
            'data-update'=>'data-update="content_viabilita_e1"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_viabilita_e1"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.$last_page .'"',
            'data-update'=>'data-update="content_viabilita_e1"'
        );
    }
    ?>
    <div id="scrollcontrols">
        <span>
        <a <?php echo $actions['first']['url'];?> <?php echo $actions['first']['data-update'];?> >
            <img class="actions first" src="images/empty.png" title="Primo">
        </a>
        <a <?php echo $actions['prev']['url'];?> <?php echo $actions['prev']['data-update'];?> >
            <img class="actions prev" src="images/empty.png" title="Precedente">
        </a>
        </span>
        <span>
            Nota <input id="current" name="current" value="<?php echo $start; ?>" type="text"  /> di <?php echo $countall; ?></span>
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
    