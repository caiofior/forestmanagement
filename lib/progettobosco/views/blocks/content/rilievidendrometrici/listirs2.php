<div id="content_rilievidendrometrici_listirs2" >
    <?php 
        $f2coll = $f->getF2Coll();
        if (!key_exists('start', $_GET))
            $_GET['start']=0;
        if (!key_exists('search', $_GET))
            $_GET['search']=null;
        if (!key_exists('regione', $_GET))
            $_GET['regione']=null;
        unset($_GET['delete']);
        $items_in_page =10;
        $f2coll->loadAll(
                array(
            'start'=>$_GET['start'],
            'length'=>$items_in_page,
            'search'=>$_GET['search'],
            'regione'=>$_GET['regione']
        )
        );
    foreach($f2coll->getItems() as $f2) :
    ?>
    <div>
        <span>
            <div>
            <input type="hidden" id="specie_<?php echo $f2->getData('objectid'); ?>" name="specie_<?php echo $f2->getData('objectid'); ?>" value="<?php echo $f2->getData('specie'); ?>"/>
            <input id="specie_descr_<?php echo $f2->getData('objectid'); ?>" name="specie_descr_<?php echo $f2->getData('objectid'); ?>" value="<?php echo $f2->getRawData('specie_descriz'); ?>"/>
            </div>
        </span>
        
        <span>
            <div>
            <input id="d2_<?php echo $f2->getData('objectid'); ?>" name="d2_<?php echo $f2->getData('objectid'); ?>" value="<?php echo $f2->getData('d'); ?>"/>
            </div>
        </span>
        <span>
            <div>
            <input id="h2_<?php echo $f2->getData('objectid'); ?>" name="h2_<?php echo $f2->getData('objectid'); ?>" value="<?php echo $f2->getData('h'); ?>"/>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formc1&amp;action=editarbustive&amp;id=<?php echo $f->getData('objectid');?>" data-update="content_rilievidendrometrici_listirs2">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
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
    $countall =$f2coll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_rilievidendrometrici_listirs2"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&start=0"',
            'data-update'=>'data-update="content_rilievidendrometrici_listirs2"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_rilievidendrometrici_listirs2"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
            'data-update'=>'data-update="content_rilievidendrometrici_listirs2"'
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
            Specie <input id="current" name="current" value="<?php echo $start; ?>" type="text"  /> di <?php echo $countall; ?>
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