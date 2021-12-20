<?php
$b4 = new \forest\entity\b\B4();
try{
$b4->loadFromId($_REQUEST['id']);
} catch (Exception $e) {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
    $bcoll = $a->getBColl();
    if ($bcoll->count() == 0) {
        $b = $bcoll->addItem ();
        $b->insert();
        $bcoll = $a->getBColl();
    }
    $b = $bcoll->getFirst();
    $b4coll = $b->getB4Coll();
    if($b4coll->count() == 0) {
        $b4 = $b4coll->addItem ();
        $b4->insert();
        $b4coll = $b->getB4Coll();
    }
    $b4 = $b4coll->getFirst();
}
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
                case 'editarbustive':
            if (key_exists('arbustive_id', $_REQUEST)) {
                $shrubcomposition = new \forest\attribute\shrubcomposition\B3();
                $shrubcomposition->loadFromId($_REQUEST['arbustive_id']);
            }
            else {
                $shrubcompositioncoll = $b4->getShrubCompositionColl();
                $shrubcomposition = $shrubcompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu_ar'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu_ar','la specie','f');
           
            $shrubcomposition->setData($_REQUEST['cod_coltu_ar'],'cod_coltu');
            if (key_exists('arbustive_id', $_REQUEST))
                $shrubcomposition->update();
            else
                $shrubcomposition->insert();
        break;
        case 'editerbacee':
            if (key_exists('erbacee_id', $_REQUEST)) {
                $herbaceuscomposition = new \forest\attribute\herbaceuscomposition\B3();
                $herbaceuscomposition->loadFromId($_REQUEST['erbacee_id']);
            }
            else {
                $herbaceuscompositioncoll = $b4->getHerbaceusCompositionColl();
                $herbaceuscomposition = $herbaceuscompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu_er'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu_er','la specie','f');
           
            $herbaceuscomposition->setData($_REQUEST['cod_coltu_er'],'cod_coltu');
            if (key_exists('erbacee_id', $_REQUEST))
                $herbaceuscomposition->update();
            else
                $herbaceuscomposition->insert();
        break;
        case 'editarboree':
            if (key_exists('arboree_id', $_REQUEST)) {
                $b4covercomposition = new \forest\attribute\covercomposition\B3();
                $b4covercomposition->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $b4covercompositioncoll = $b4->getCoverCompositionColl();
                $b4covercomposition = $forestcovercompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            
            $b4covercomposition->setData($_REQUEST['cod_coltu2'],'cod_coltu');
                if (key_exists('arboree_id', $_REQUEST))
                    $b4covercomposition->update();
                else
                    $b4covercomposition->insert();
        break;
         case 'update':
            if($_REQUEST['codice_bosco']== '')
                $formErrors->addError(FormErrors::required,'codice_bosco','bosco');
            if(!key_exists('u', $_REQUEST) || $_REQUEST['u']== '')
                $_REQUEST['u']='0';
            if(!key_exists('objectid', $_REQUEST) || $_REQUEST['objectid']== '') {
                $_REQUEST['objectid']=new \Zend_Db_Expr('DEFAULT');
            }
            
            if($_REQUEST['ce_min2'] != '' ) {
                if (!filter_var($_REQUEST['ce_min2'],FILTER_VALIDATE_FLOAT))
                    $formErrors->addError(FormErrors::valid_float,'ce_min2','copertura (%)');
            }
            
            if($_REQUEST['h_min2'] != '' ) {
                if (!filter_var($_REQUEST['h_min2'],FILTER_VALIDATE_FLOAT))
                    $formErrors->addError(FormErrors::valid_float,'h_min2','altezza media');
            }
            
            if($_REQUEST['ce_mag2'] != '' ) {
                if (!filter_var($_REQUEST['ce_mag2'],FILTER_VALIDATE_FLOAT))
                    $formErrors->addError(FormErrors::valid_float,'ce_mag2','copertura (%)');
            }
            
            if($_REQUEST['h_mag2'] != '' ) {
                if (!filter_var($_REQUEST['h_mag'],FILTER_VALIDATE_FLOAT))
                    $formErrors->addError(FormErrors::valid_float,'h_mag','altezza media');
            }
            
            $formErrors->setOkMessage(' I dati sono stati salvati alle '.  strftime('%k:%M:%S del %d %b'));
            if ($formErrors->count() == 0) {
                $b4->setData($_REQUEST);
                $b4->update();
                $log->setData(array(
                    'user_id'=>$user->getData('id'),
                    'username'=>$user->getData('username'),
                    'description'=>'Modifica della Scheda B4 '.$b4->getData('proprieta').' '.$b4->getData('cod_part'),
                    'objectid'=>$b4->getData('objectid'),
                ));
            }
            $formErrors->getJsonError();
            exit;
    }
}
if (key_exists('deletearbustive', $_REQUEST)) {
    $shrubcomposition = new \forest\attribute\shrubcomposition\B3();
    $shrubcomposition->loadFromId($_REQUEST['deletearbustive']);
    $shrubcomposition->delete();
} else if (key_exists('deleteerbacee', $_REQUEST)) {
    $herbaceuscomposition = new \forest\attribute\herbaceuscomposition\B3();
    $herbaceuscomposition->loadFromId($_REQUEST['deleteerbacee']);
    $herbaceuscomposition->delete();
} else if (key_exists('deletearboree', $_REQUEST)) {
    $corkcovercomposition = new \forest\attribute\covercomposition\B3();
    $corkcovercomposition->loadFromId($_REQUEST['deletearboree']);
    $corkcovercomposition->delete();
} 