<?php
$b1 = new \forest\entity\b\B1();
try{
$b1->loadFromId($_REQUEST['id']);
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
    $b1coll = $b->getB1Coll();
    if($b1coll->count() == 0) {
        $b1 = $b1coll->addItem ();
        $b1->insert();
        $b1coll = $b->getB1Coll();
    }
    $b1 = $b1coll->getFirst();
}
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'editarboree':
            if (key_exists('arboree_id', $_REQUEST)) {
                $forestcovercomposition = new \forest\attribute\covercomposition\B1();
                $forestcovercomposition->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $forestcovercompositioncoll = $b1->getCoverCompositionColl();
                $forestcovercomposition = $forestcovercompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            if ($_REQUEST['cod_coper'] == '')
                $formErrors->addError(FormErrors::required,'cod_coper','la copertura','f');
            
            $forestcovercomposition->setData($_REQUEST['cod_coltu'],'cod_coltu');
            $forestcovercomposition->setData($_REQUEST['cod_coper'],'cod_coper');
                if (key_exists('arboree_id', $_REQUEST))
                    $forestcovercomposition->update();
                else
                    $forestcovercomposition->insert();
        break;
        case 'editarbustive':
            if (key_exists('arbustive_id', $_REQUEST)) {
                $shrubcomposition = new \forest\attribute\shrubcomposition\B1();
                $shrubcomposition->loadFromId($_REQUEST['arbustive_id']);
            }
            else {
                $shrubcompositioncoll = $b1->getShrubCompositionColl();
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
                $herbaceuscomposition = new \forest\attribute\herbaceuscomposition\B1();
                $herbaceuscomposition->loadFromId($_REQUEST['erbacee_id']);
            }
            else {
                $herbaceuscompositioncoll = $b1->getHerbaceusCompositionColl();
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
        case 'editdesteem':
            if (key_exists('arboree_id', $_REQUEST)) {
                $forestmassesteem = new \forest\attribute\ForestMassEsteem();
                $forestmassesteem->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $forestmassesteemcoll = $b1->getForestMassEsteemColl();
                $forestmassesteem = $forestmassesteemcoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            if ($_REQUEST['cod_coper'] == '')
                $formErrors->addError(FormErrors::required,'cod_coper','la copertura','f');
            if ($_REQUEST['massa_tot'] == '')
                $formErrors->addError(FormErrors::required,'massa_tot','la massa totale','f');            
            $forestmassesteem->setData($_REQUEST['cod_coltu'],'cod_coltu');
            $forestmassesteem->setData(substr($_REQUEST['cod_coper'],0,1),'cod_coper');
            $forestmassesteem->setData($_REQUEST['massa_tot'],'massa_tot');
                if (key_exists('arboree_id', $_REQUEST))
                    $forestmassesteem->update();
                else
                    $forestmassesteem->insert();
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
                   $note = new \forest\attribute\note\B();
                   $note->loadFromId($_REQUEST['note_id']);
                } else {
                    $notes = $b1->getNotes();
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
            if($_REQUEST['c1'] != '' && !is_numeric($_REQUEST['c1']))
                $formErrors->addError(FormErrors::valid_float,'c1','età prevalente','f');
            
            if($_REQUEST['ce'] != '' ) {
                if (!is_numeric($_REQUEST['ce']))
                    $formErrors->addError(FormErrors::valid_float,'ce','grado di copertura');
                else if($_REQUEST['ce']< 1 || $_REQUEST['ce']> 100)
                    $formErrors->addError(FormErrors::custom,'ce','il grado di copertura deve essere compreso tra 1 e 100');
            }
            
            if($_REQUEST['d1'] != '' ) {
                if (!is_numeric($_REQUEST['d1']))
                    $formErrors->addError(FormErrors::valid_float,'d1','diametro prevalente');
                else if($_REQUEST['d1']< 1 )
                    $formErrors->addError(FormErrors::custom,'d1','il diametro prevalente deve essere maggiore di 1');
            }
            
            if($_REQUEST['d3'] != '' ) {
                if (!is_numeric($_REQUEST['d3']))
                    $formErrors->addError(FormErrors::valid_float,'d3','altezza prevalente');
                else if($_REQUEST['d3']< 1 )
                    $formErrors->addError(FormErrors::custom,'d3','l\'altezza prevalente deve essere maggiore di 1');
            }
            
            if($_REQUEST['d5'] != '' ) {
                if (!filter_var($_REQUEST['d5'],FILTER_VALIDATE_INT) )
                    $formErrors->addError(FormErrors::valid_int,'d5','n°\alberi/ha');
                else if($_REQUEST['d5']< 1 )
                    $formErrors->addError(FormErrors::custom,'d5','il n°\alberi/ha deve essere maggiore di 1');
            }
            
            if($_REQUEST['d14'] != '' ) {
                if (!is_numeric($_REQUEST['d14']))
                    $formErrors->addError(FormErrors::valid_float,'d14','diametro prevalente');
                else if($_REQUEST['d14']< 1 )
                    $formErrors->addError(FormErrors::custom,'d14','il diametro prevalente deve essere maggiore di 1');
            }
            
            if($_REQUEST['d15'] != '' ) {
                if (!is_numeric($_REQUEST['d15']))
                    $formErrors->addError(FormErrors::valid_float,'d15','altezza prevalente');
                else if($_REQUEST['d15']< 1 )
                    $formErrors->addError(FormErrors::custom,'d15','l\'altezza prevalente deve essere maggiore di 1');
            }
            
            if($_REQUEST['sesto_imp_tra_file'] != '' ) {
                if (!is_numeric($_REQUEST['sesto_imp_tra_file']))
                    $formErrors->addError(FormErrors::valid_float,'sesto_imp_tra_file','sesto d\'impianto tra file');
                else if($_REQUEST['sesto_imp_tra_file']< 1 )
                    $formErrors->addError(FormErrors::custom,'sesto_imp_tra_file','il sesto d\'impianto tra file deve essere maggiore di 1');
            }
            
            if($_REQUEST['sesto_imp_su_file'] != '' ) {
                if (!is_numeric($_REQUEST['sesto_imp_su_file']))
                    $formErrors->addError(FormErrors::valid_float,'sesto_imp_su_file','sesto d\'impianto sulla fila');
                else if($_REQUEST['sesto_imp_su_file']< 1 )
                    $formErrors->addError(FormErrors::custom,'sesto_imp_su_file','il sesto d\'impianto sulla fila deve essere maggiore di 1');
            }
            
            if($_REQUEST['buche'] != '' ) {
                if (!filter_var($_REQUEST['buche'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_int,'buche','buche');
                else if($_REQUEST['buche']< 1 )
                    $formErrors->addError(FormErrors::custom,'buche','le buche devono essere maggiori di 1');
            }
            
            if($_REQUEST['d21'] != '' ) {
                if (!is_numeric($_REQUEST['d21']))
                    $formErrors->addError(FormErrors::valid_float,'d21','provvigione reale','f');
                else if($_REQUEST['d21']< 1 )
                    $formErrors->addError(FormErrors::custom,'d21','la provvigione reale essere maggiore di 1');
            }
            
            if($_REQUEST['d22'] != '' ) {
                if (!is_numeric($_REQUEST['d22']))
                    $formErrors->addError(FormErrors::valid_float,'d22','provvigione reale','f');
                else if($_REQUEST['d22']< 1 )
                    $formErrors->addError(FormErrors::custom,'d22','la provvigione reale essere maggiore di 1');
            }
            
            if($_REQUEST['d23'] != '' ) {
                if (!is_numeric($_REQUEST['d23']))
                    $formErrors->addError(FormErrors::valid_float,'d23','incremento corrente');
                else if($_REQUEST['d23']< 1 )
                    $formErrors->addError(FormErrors::custom,'d23','l\'incremento corrente essere maggiore di 1');
            }
            
            if($_REQUEST['d24'] != '' ) {
                if (!is_numeric($_REQUEST['d24']))
                    $formErrors->addError(FormErrors::valid_float,'d24','incremento corrente');
                else if($_REQUEST['d24']< 1 )
                    $formErrors->addError(FormErrors::custom,'d24','l\'incremento corrente essere maggiore di 1');
            }
            
            if($_REQUEST['d25'] != '' ) {
                if (!is_numeric($_REQUEST['d25']))
                    $formErrors->addError(FormErrors::valid_float,'d25','provvigione normale','f');
                else if($_REQUEST['d25']< 1 )
                    $formErrors->addError(FormErrors::custom,'d25','la provvigione normale essere maggiore di 1');
            }
            
            if($_REQUEST['d26'] != '' ) {
                if (!is_numeric($_REQUEST['d26']) || intval($_REQUEST['d26']) != floatval($_REQUEST['d26']) )
                    $formErrors->addError(FormErrors::valid_int,'d26','classe di feacità', 'f');
                else if($_REQUEST['d5']< 1 )
                    $formErrors->addError(FormErrors::custom,'d26','la classe di feacità deve essere maggiore di 1');
            }
            
            $formErrors->setOkMessage(' I dati sono stati salvati alle '.  strftime('%k:%M:%S del %d %b'));
            if ($formErrors->count() == 0) {
                $b1->setData($_REQUEST);
                $b1->update();
                $log->setData(array(
                    'user_id'=>$user->getData('id'),
                    'username'=>$user->getData('username'),
                    'description'=>'Modifica della Scheda B1 '.$b1->getData('proprieta').' '.$b1->getData('cod_part'),
                    'objectid'=>$b1->getData('objectid'),
                ));
            }
            $formErrors->getJsonError();
            exit;
        break;
    }
}
if (key_exists('deletearboree', $_REQUEST)) {
    $forestcovercomposition = new \forest\attribute\covercomposition\B1();
    $forestcovercomposition->loadFromId($_REQUEST['deletearboree']);
    $forestcovercomposition->delete();
} else if (key_exists('deletearbustive', $_REQUEST)) {
    $shrubcomposition = new \forest\attribute\shrubcomposition\B1();
    $shrubcomposition->loadFromId($_REQUEST['deletearbustive']);
    $shrubcomposition->delete();
} else if (key_exists('deleteerbacee', $_REQUEST)) {
    $herbaceuscomposition = new \forest\attribute\herbaceuscomposition\B1();
    $herbaceuscomposition->loadFromId($_REQUEST['deleteerbacee']);
    $herbaceuscomposition->delete();
} else if (key_exists('deletemassesteem', $_REQUEST)) {
    $forestmassesteem = new \forest\attribute\ForestMassEsteem();
    $forestmassesteem->loadFromId($_REQUEST['deletemassesteem']);
    $forestmassesteem->delete();
} else if (key_exists('deletenote', $_REQUEST)) {
    $notab = new \forest\attribute\note\B();
    $notab->loadFromId($_REQUEST['deletenote']);
    $notab->delete();
}

