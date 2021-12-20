<div id="content_rilievidendrometrici_listict1" >
    <?php 
        $c1coll = $c->getC1Coll();
        if (!key_exists('start', $_GET))
            $_GET['start']=0;
        if (!key_exists('search', $_GET))
            $_GET['search']=null;
        if (!key_exists('regione', $_GET))
            $_GET['regione']=null;
        unset($_GET['delete']);
        $items_in_page =10;
        $c1coll->loadAll(
                array(
            'start'=>$_GET['start'],
            'length'=>$items_in_page,
            'search'=>$_GET['search'],
            'regione'=>$_GET['regione']
        )
        );
    foreach($c1coll->getItems() as $c1) :
    ?>
    <div>
        <span>
            <div>
            <input id="diam_<?php echo $c1->getData('objectid'); ?>" name="diam_<?php echo $c1->getData('objectid'); ?>" value="<?php echo $c1->getData('diam'); ?>"/>
            </div>
        </span>
        <span>
            <div>
            <input type="hidden" id="specie_<?php echo $c1->getData('objectid'); ?>" name="specie_<?php echo $c1->getData('objectid'); ?>" value="<?php echo $c1->getData('specie'); ?>"/>
            <input id="specie_descr_<?php echo $c1->getData('objectid'); ?>" name="specie_descr_<?php echo $c1->getData('objectid'); ?>" value="<?php echo $c1->getRawData('specie_descriz'); ?>"/>
            </div>
        </span>
        
        <span>
            <div>
            <input id="rilievo_<?php echo $c1->getData('objectid'); ?>" name="rilievo_<?php echo $c1->getData('objectid'); ?>" value="<?php echo $c1->getData('rilievo'); ?>"/>
            </div>
        </span>
        <span>
            <div>
            <input id="prelievo_<?php echo $c1->getData('objectid'); ?>" name="prelievo_<?php echo $c1->getData('objectid'); ?>" value="<?php echo $c1->getData('prelievo'); ?>"/>
            </div>
        </span>
        <span>
            <div>
            <select id="poll_matr_<?php echo $c1->getData('objectid'); ?>" name="poll_matr_<?php echo $c1->getData('objectid'); ?>" >
                <option></option>
                <?php foreach( $c1->getControl('poll_matr')->getItems() as $poll) :
                $selected = '';
                if ($poll->getData('codice') == $c1->getData('poll_matr')) $selected='selected="selected"';
                ?>
                <option <?php echo $selected;?> value="<?php echo $poll->getData('codice'); ?>"><?php echo $poll->getData('descriz'); ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formc1&amp;action=editarbustive&amp;id=<?php echo $c->getData('objectid');?>" data-update="content_rilievidendrometrici_irc1">
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
    $countall =$c1coll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_rilievidendrometrici_listict1"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&start=0"',
            'data-update'=>'data-update="content_rilievidendrometrici_listict1"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_rilievidendrometrici_listict1"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
            'data-update'=>'data-update="content_rilievidendrometrici_listict1"'
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