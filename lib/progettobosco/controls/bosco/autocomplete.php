<?php
$response=array();
switch ($_REQUEST['action']) {
    case 'municipality' :
        if (!key_exists('codice', $_REQUEST))
                $_REQUEST['codice']=null;
        $municipalitycoll = new forest\attribute\MunicipalityColl();
        $municipalitycoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term'],
            'codice_bosco'=>$_REQUEST['codice']
            ));

        foreach($municipalitycoll->getItems() as $municipality) {
            $data = array(
                'id'=>$municipality->getData('codice'),
                'value'=>$municipality->getData('descriz').' ('.$municipality->getRawData('province_code').')'
            );
            $response[]=$data;
        }
    break;
    case 'collector':
        $collectorcoll = new \forest\attribute\CollectorColl();
        $collectorcoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term']
            ));
        foreach($collectorcoll->getItems() as $collector) {
            $data = array(
                'id'=>$collector->getData('codice'),
                'value'=>$collector->getData('descriz')
            );
            $response[]=$data;
        }
    break;
    case 'cod_nota':
        $notacoll = new \forest\attribute\note\TemplateColl();
        $archivio = 'SCHEDE_A';
        if (key_exists('archivio',$_REQUEST)) {
            switch ($_REQUEST['archivio']) {
                case 'schedab':
                    $archivio='SCHEDE_B';
                break;
                case 'schedab2':
                    $archivio='SCHED_B2';
                break;
                case 'schedab3':
                    $archivio='SCHED_B3';
                break;
                case 'schedab4':
                    $archivio='SCHED_B4';
                break;
                case 'schedan':
                    $archivio='SCHEDE_N';
                break;
            }
        }
        $notacoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'archivio'=>$archivio,
            'search'=>$_REQUEST['term']
            ));
        foreach($notacoll->getItems() as $nota) {
            $data = array(
                'id'=>$nota->getData('objectid'),
                'value'=>$nota->getData('intesta')
            );
            $response[]=$data;
        }
    break;
    case 't':
        if (!key_exists('codice', $_REQUEST))
                $_REQUEST['codice']=null;
        $tcoll = new forest\attribute\ForestTypeColl();
        $tcoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term'],
            'codice_bosco'=>$_REQUEST['codice']
            ));
        foreach($tcoll->getItems() as $t) {
            $data = array(
                'id'=>$t->getData('codice'),
                'value'=>$t->getData('descriz')
            );
            $response[]=$data;
        }
    break;
    case 's':
        if (!key_exists('codice', $_REQUEST))
                $_REQUEST['codice']=null;
        $scoll = new forest\attribute\StructureColl();
        $scoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term'],
            'codice_bosco'=>$_REQUEST['codice']
            ));
        foreach($scoll->getItems() as $s) {
            $data = array(
                'id'=>$s->getData('codice'),
                'value'=>$s->getData('descriz')
            );
            $response[]=$data;
        }
    break;
    case 'cod_coltu':
        if (!key_exists('objectid', $_REQUEST))
                $_REQUEST['objectid']=null;
        $arborealcoll = new forest\attribute\ArborealColl();
        $arborealcoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term'],
            'b1_objectid'=>$_REQUEST['objectid']
            ));
        foreach($arborealcoll->getItems() as $arboreal) {
            $data = array(
                'id'=>$arboreal->getData('cod_coltu'),
                'value'=>$arboreal->getData('nome_itali').' | '.$arboreal->getData('nome_scien')
            );
            $response[]=$data;
        }
    break;
    case 'cod_coltu_ar':
        if (!key_exists('objectid', $_REQUEST))
                $_REQUEST['objectid']=null;
        $arborealcoll = new forest\attribute\ArborealColl();
        $arborealcoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term'],
            'shrub'=>true,
            'b1_objectid'=>$_REQUEST['objectid']
            ));
        foreach($arborealcoll->getItems() as $arboreal) {
            $data = array(
                'id'=>$arboreal->getData('cod_coltu'),
                'value'=>$arboreal->getData('nome_itali').' | '.$arboreal->getData('nome_scien')
            );
            $response[]=$data;
        }
    break;
    case 'cod_coltu_er':
        if (!key_exists('objectid', $_REQUEST))
                $_REQUEST['objectid']=null;
        $herbaceacoll = new forest\attribute\HerbaceaColl();
        $herbaceacoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term'],
            'b1_objectid'=>$_REQUEST['objectid']
            ));
        foreach($herbaceacoll->getItems() as $herbacea) {
            $data = array(
                'id'=>$herbacea->getData('cod_coltu'),
                'value'=>$herbacea->getData('nome')
            );
            $response[]=$data;
        }
    break;
    case 'cod_coltu_d':
        if (!key_exists('objectid', $_REQUEST))
                $_REQUEST['objectid']=null;
        $arborealcoll = new forest\attribute\ArborealColl();
        $arborealcoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'mass_esteem'=>true,
            'search'=>$_REQUEST['term'],
            'b1_objectid'=>$_REQUEST['objectid']
            ));
        foreach($arborealcoll->getItems() as $arboreal) {
            $data = array(
                'id'=>$arboreal->getData('cod_coltu'),
                'value'=>$arboreal->getData('nome_itali').' | '.$arboreal->getData('nome_scien')
            );
            $response[]=$data;
        }
    break;
    case 'cod_inter' :
        $codintcoll = new forest\attribute\ViabilityInterventColl();
        $codintcoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'mass_esteem'=>true,
            'search'=>$_REQUEST['term']
            ));
        foreach($codintcoll->getItems() as $codint) {
            $data = array(
                'id'=>$codint->getData('codice'),
                'value'=>$codint->getData('descriz')
            );
            $response[]=$data;
        }
    break;
}
header('Content-type: application/json');
echo Zend_Json::encode($response);
exit;
