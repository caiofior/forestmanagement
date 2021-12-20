<?php
$b2 = new \forest\entity\b\B2();
try{
$b2->loadFromId($_REQUEST['id']);
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
    $b2coll = $b->getB2Coll();
    if($b2coll->count() == 0) {
        $b2 = $b2coll->addItem ();
        $b2->insert();
        $b2coll = $b->getB2Coll();
    }
    $b2 = $b2coll->getFirst();
}
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'editarboree':
            if (key_exists('arboree_id', $_REQUEST)) {
                $corkcovercomposition = new \forest\attribute\covercomposition\B2();
                $corkcovercomposition->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $corkcovercompositioncoll = $b2->getCoverCompositionColl();
                $corkcovercomposition = $forestcovercompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            if ($_REQUEST['cod_coper'] == '')
                $formErrors->addError(FormErrors::required,'cod_coper','la copertura','f');
            
            $corkcovercomposition->setData($_REQUEST['cod_coltu'],'cod_coltu');
            $corkcovercomposition->setData($_REQUEST['cod_coper'],'cod_coper');
                if (key_exists('arboree_id', $_REQUEST))
                    $corkcovercomposition->update();
                else
                    $corkcovercomposition->insert();
        break;
        case 'editarbustive':
            if (key_exists('arbustive_id', $_REQUEST)) {
                $shrubcomposition = new \forest\attribute\shrubcomposition\B2();
                $shrubcomposition->loadFromId($_REQUEST['arbustive_id']);
            }
            else {
                $shrubcompositioncoll = $b2->getShrubCompositionColl();
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
                $herbaceuscomposition = new \forest\attribute\herbaceuscomposition\B2();
                $herbaceuscomposition->loadFromId($_REQUEST['erbacee_id']);
            }
            else {
                $herbaceuscompositioncoll = $b2->getHerbaceusCompositionColl();
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
        case 'editnote' :
            $notatemplate = new \forest\attribute\note\Template();
            if ($_REQUEST['cod_nota'] == '')
                $formErrors->addError(FormErrors::required,'cod_nota','l\'intestazione','f');
            else {
                $notatemplate->loadFromId($_REQUEST['cod_nota']);
                if(is_null($notatemplate->getData()))
                    $formErrors->addError(FormErrors::wrong,'cod_nota','l\'intestazione','f');
            }
            if ($_REQUEST['text_nota'] == '') {
                $formErrors->addError(FormErrors::required,'text_nota','testo');
            }
            
            if ($formErrors->count() == 0) {
                if (key_exists('note_id', $_REQUEST)) {
                   $note = new \forest\attribute\note\B2();
                   $note->loadFromId($_REQUEST['note_id']);
                } else {
                    $notes = $b2->getNotes();
                    $note = $notes->addItem();
                }
                $note->setData($notatemplate->getData('nomecampo'),'cod_nota');
                $note->setData($_REQUEST['text_nota'],'nota');
                if (key_exists('note_id', $_REQUEST))
                    $note->update();
                else
                    $note->insert();
            }
            if (key_exists('xhr', $_REQUEST)) {
                $formErrors->getJsonError ();
                exit;
            }
        break;
         case 'update':
            if($_REQUEST['codice_bosco']== '')
                $formErrors->addError(FormErrors::required,'codice_bosco','bosco');
            if(!key_exists('u', $_REQUEST) || $_REQUEST['u']== '')
                $_REQUEST['u']='0';
            if(!key_exists('objectid', $_REQUEST) || $_REQUEST['objectid']== '') {
                $_REQUEST['objectid']=new \Zend_Db_Expr('DEFAULT');
            }
            
            if($_REQUEST['anno_imp'] != '' ) {
                if (!filter_var($_REQUEST['anno_imp'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'anno_imp','anno d\'impianto');
            }
            
            if($_REQUEST['anno_dest'] != '' ) {
                if (!filter_var($_REQUEST['anno_dest'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'anno_dest','anno di cambiamento della destinazione');
            }
            
            if($_REQUEST['dist'] != '' ) {
                if (!filter_var($_REQUEST['dist'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'dist','distanza tra le piante');
            }
            
            if($_REQUEST['dist_princ'] != '' ) {
                if (!filter_var($_REQUEST['dist_princ'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'dist_princ','distanza tra la specie principale');
            }
            
            if($_REQUEST['fall'] != '' ) {
                if (!is_numeric($_REQUEST['fall']))
                    $formErrors->addError(FormErrors::valid_float,'fall','% fallanze');
                else if($_REQUEST['fall']< 1 || $_REQUEST['fall']> 100)
                    $formErrors->addError(FormErrors::custom,'fall','la percentuale di fallanze deve essere compresa tra 1 e 100');
            }
            
            
            if($_REQUEST['num_piante'] != '' ) {
                if (!filter_var($_REQUEST['num_piante'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'num_piante','numero di piante/ha');
            }
            
            if($_REQUEST['piant_tart'] != '' ) {
                if (!filter_var($_REQUEST['piant_tart'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'piant_tart','numero di piante tartufigene/ha');
            }
            
            if($_REQUEST['estraz_passata'] != '' ) {
                if (!filter_var($_REQUEST['estraz_passata'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'estraz_passata','anno estrazione passata');
            }
            
            if($_REQUEST['d5'] != '' ) {
                if (!filter_var($_REQUEST['d5'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'d5','n° alberi /ha');
            }
            
            if($_REQUEST['d10'] != '' ) {
                if (!filter_var($_REQUEST['d10'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'d10','n° alberi produttivi/ha');
            }
            
            if($_REQUEST['d11'] != '' ) {
                if (!filter_var($_REQUEST['d11'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'d11','n° polloni/ha');
            }
            
            if($_REQUEST['d12'] != '' ) {
                if (!filter_var($_REQUEST['d12'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'d12','n° monocauli/ha');
            }
            
            if($_REQUEST['d1'] != '' ) {
                if (!filter_var($_REQUEST['d1'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'d1','diametro preval.(cm)');
            }
 
            if($_REQUEST['d3'] != '' ) {
                if (!filter_var($_REQUEST['d3'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'d3','altezza preval.(cm)');
            }

            if($_REQUEST['d13'] != '' ) {
                if (!is_numeric($_REQUEST['d13']))
                    $formErrors->addError(FormErrors::valid_int,'d13','Produzione media (q)');
            }
            if($_REQUEST['c1'] != '' ) {
                if (!filter_var($_REQUEST['c1'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'c1','età prevalente accertata');
            }
            
            if($_REQUEST['ce'] != '' ) {
                if (!is_numeric($_REQUEST['ce']))
                    $formErrors->addError(FormErrors::valid_float,'ce','grado di copertura');
                else if($_REQUEST['ce']< 1 || $_REQUEST['ce']> 100)
                    $formErrors->addError(FormErrors::custom,'ce','il grado di copertura deve essere compreso tra 1 e 100');
            }
            
            if($_REQUEST['estraz_futura'] != '' ) {
                if (!filter_var($_REQUEST['estraz_futura'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'estraz_futura','anno previsto per estrazione sughero');
            }
            
            $formErrors->setOkMessage(' I dati sono stati salvati alle '.  strftime('%k:%M:%S del %d %b'));
            if ($formErrors->count() == 0) {
                $b2->setData($_REQUEST);
                $b2->update();
                $log->setData(array(
                    'user_id'=>$user->getData('id'),
                    'username'=>$user->getData('username'),
                    'description'=>'Modifica della Scheda B2 '.$b2->getData('proprieta').' '.$b2->getData('cod_part'),
                    'objectid'=>$b2->getData('objectid'),
                ));
            }
            $formErrors->getJsonError();
            exit;
    }
}
if (key_exists('deletearboree', $_REQUEST)) {
    $corkcovercomposition = new \forest\attribute\covercomposition\B2();
    $corkcovercomposition->loadFromId($_REQUEST['deletearboree']);
    $corkcovercomposition->delete();
} else if (key_exists('deletearbustive', $_REQUEST)) {
    $shrubcomposition = new \forest\attribute\shrubcomposition\B2();
    $shrubcomposition->loadFromId($_REQUEST['deletearbustive']);
    $shrubcomposition->delete();
} else if (key_exists('deleteerbacee', $_REQUEST)) {
    $herbaceuscomposition = new \forest\attribute\herbaceuscomposition\B2();
    $herbaceuscomposition->loadFromId($_REQUEST['deleteerbacee']);
    $herbaceuscomposition->delete();
} else if (key_exists('deletenote', $_REQUEST)) {
    $notab = new \forest\attribute\note\B2();
    $notab->loadFromId($_REQUEST['deletenote']);
    $notab->delete();
}