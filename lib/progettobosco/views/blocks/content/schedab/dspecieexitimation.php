<div id="content_schedab_dspecieexitimation">
    <?php
    if (!isset($b1)) {
        $b1 = new \forest\entity\b\B1();
        $b1->loadFromId($_REQUEST['id']);
    }
    $forestmassesteem = new \forest\attribute\ForestMassEsteem();
    $cod_coper_coll= $forestmassesteem->getControl('cod_coper');
    $forestmassesteemcoll = $b1->getForestMassEsteemColl();
    
    if (!key_exists('start', $_GET))
            $_GET['start']=0;
    $items_in_page =2;
    
    $forestmassesteemcoll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));

    foreach ($forestmassesteemcoll->getItems() as $forestmassesteem) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_coltu_d_<?php echo $forestmassesteem->getRawData('objectid');?>" name="cod_coltu_d_<?php echo $forestmassesteem->getRawData('objectid');?>" value="<?php echo $forestmassesteem->getRawData('cod_coltu');?>"/>
                <input class="arboree" id="cod_coltu_d_descr_<?php echo $forestmassesteem->getRawData('objectid');?>" data-arboree-id="<?php echo $forestmassesteem->getRawData('objectid');?>" name="cod_coltu_d_descr_<?php echo $forestmassesteem->getRawData('objectid');?>" value="<?php echo $forestmassesteem->getRawData('cod_colt_descriz');?>" data-old-value="<?php echo $forestmassesteem->getRawData('cod_colt_descriz');?>">
            </div>
        </span>
        <span>
            <div>
                <select id="cod_coper_d_<?php echo $forestmassesteem->getRawData('objectid');?>" name="cod_coper_d_<?php echo $forestmassesteem->getRawData('objectid');?>" data-arboree-id="<?php echo $forestmassesteem->getRawData('objectid');?>">
                    <option value="">Scegli un valore di copertura</option>
                    <?php
                    foreach($cod_coper_coll->getItems() as $item) :
                    $selected = '';
                    if ($item->getRawData('codice') == $forestmassesteem->getRawData('cod_coper'))
                        $selected = 'selected="selected"';
                    ?>
                    <option <?php echo $selected; ?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </span>
        <span>
            <div>
                <input id="massa_tot_<?php echo $forestmassesteem->getRawData('objectid');?>" name="massa_tot_<?php echo $forestmassesteem->getRawData('objectid');?>" data-arboree-id="<?php echo $forestmassesteem->getRawData('objectid');?>" value="<?php echo $forestmassesteem->getRawData('massa_tot');?>"/>
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&id=<?php echo $b1->getData('objectid');?>&deletemassesteem=<?php echo $forestmassesteem->getRawData('objectid');?>"  >
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
    $countall =$forestmassesteemcoll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedab_dspecieexitimation"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&start=0"',
            'data-update'=>'data-update="content_schedab_dspecieexitimation"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedab_dspecieexitimation"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
            'data-update'=>'data-update="content_schedab_dspecieexitimation"'
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
    