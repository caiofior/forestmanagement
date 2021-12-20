<div id="content_schedab4_note">

    <?php
    if (!isset($b4)) {
        $b4 = new \forest\entity\b\B4();
        $b4->loadFromId($_REQUEST['id']);
    }
    $notes = $b4->getNotes();
    if (!key_exists('start', $_GET))
            $_GET['start']=0;
    $items_in_page =2;
    
    $notes->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));
    foreach ($notes->getItems() as $note) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_nota_<?php echo $note->getData('objectid');?>" name="cod_nota_<?php echo $note->getData('objectid');?>" value="<?php echo $note->getRawData('nota_objectid');?>"/>
                <input id="cod_nota_descr_<?php echo $note->getData('objectid');?>" data-note-id="<?php echo $note->getData('objectid');?>" name="cod_nota_descr_<?php echo $note->getData('objectid');?>" value="<?php echo $note->getRawData('nota_descr');?>" data-old-value="<?php echo $note->getRawData('nota_descr');?>"/>
            </div>
        </span>
        <span>
            <div>
                <textarea id="text_nota_<?php echo $note->getData('objectid');?>" name="text_nota_<?php echo $note->getData('objectid');?>" data-note-id="<?php echo $note->getData('objectid');?>" rows="2" cols="30"><?php echo $note->getData('nota');?></textarea>
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&amp;id=<?php echo $b1->getData('objectid');?>&amp;deletenote=<?php echo $note->getData('objectid');?>"  >
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
    $countall =$notes->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedab4_note"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&amp;start=0"',
            'data-update'=>'data-update="content_schedab4_note"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedab4_note"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&amp;start='.$last_page .'"',
            'data-update'=>'data-update="content_schedab4_note"'
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
    