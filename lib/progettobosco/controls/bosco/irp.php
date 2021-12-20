<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * IRP page contoller
 */
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'tabledata' :
            $g1 = new \forest\entity\x\G1();
            if (
                    key_exists('id', $_REQUEST) &&
                    $_REQUEST['id'] != ''
                    )
                    $g1->loadFromId ($_REQUEST['id']);
            $gcoll = $g1->getGColl();
            $gcoll->loadAll($_REQUEST);
            $response =array(
                'sEcho'=>  intval($_REQUEST['sEcho']),
                'iTotalRecords'=>$gcoll->countAll(),
                'iTotalDisplayRecords'=>$gcoll->count(),
                'sColumns'=>  implode(',',$gcoll->getColumns()),
                'aaData'=>array()
            );
            foreach($gcoll->getItems() as $g) {
                $datarow = array();
                $datarow[]=intval($g->getData('objectid'));
                $datarow[]=intval($g->getData('n_ads'));
                $datarow[] = intval($g->getData('n_alb_cont'));
                $datarow[] = floatval($g->getData('h1'));
                $datarow[] = floatval($g->getRawData('h2'));
                $datarow[] = floatval($g->getRawData('h3'));
                $datarow[] = floatval($g->getRawData('h4'));
                $datarow[] = floatval($g->getRawData('h5'));
                $datarow[] = floatval($g->getRawData('d1'));
                $datarow[] = floatval($g->getRawData('d2'));
                $datarow[] = floatval($g->getRawData('d3'));
                $datarow[] = floatval($g->getRawData('d4'));
                $datarow[] = floatval($g->getRawData('d5'));
                $datarow[] = floatval($g->getRawData('d6'));
                $datarow[] = floatval($g->getRawData('d7'));
                ob_start();
                ?>
        <div class="table_actions">
            <a href="bosco.php?task=irp&action=tabledelete&id=<?php echo $g1->getData('objectid');?>&elementid=<?php echo $cadastral->getData('objectid');?>"><img class="actions delete" src="images/empty.png" title="Cancella"/></a>
        </div>
                <?php $datarow[]=  ob_get_clean();
                $response['aaData'][]=$datarow;
            }
            header('Content-type: application/json');
            echo Zend_Json::encode($response);
            exit;
        break;
    }
}
