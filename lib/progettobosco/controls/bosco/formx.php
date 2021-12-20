<?php
$x = new \forest\entity\x\X();
if (key_exists('id', $_REQUEST) && $_REQUEST['id'] != '') {
    $x->loadFromId($_REQUEST['id']);
    $a = $x->getFormA();
} else if (key_exists('forma_id', $_REQUEST)) {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['forma_id']);
    $b = $a->getBColl()->getFirst();
    $b1 = $b->getB1Coll()->getFirst();
    $xcoll = $b1->getXColl();
    $xcoll->loadAll();
    if ($xcoll->count() == 0)
        $x = $xcoll->addItem();
    else
        $x = $xcoll->getFirst ();
    
}
$view->x = $x;
$view->a = $a;
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
         case 'manage' :
             $content = 'content'.DIRECTORY_SEPARATOR.'rilievidendrometrici'.DIRECTORY_SEPARATOR.'manage.php';
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
                $x->setData($_REQUEST);
                $x->update();
                $log->setData(array(
                    'user_id'=>$user->getData('id'),
                    'username'=>$user->getData('username'),
                    'description'=>'Modifica della Scheda B4 '.$x->getData('proprieta').' '.$x->getData('cod_part'),
                    'objectid'=>$x->getData('objectid'),
                ));
            }
            $formErrors->getJsonError();
            exit;
    }
}
if(key_exists('action', $_REQUEST) && $_REQUEST['action'] != 'xhr_update')
unset ($_REQUEST['action']);