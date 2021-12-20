<?php
$a = new \forest\entity\A();
$a->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
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
                   $note = new \forest\attribute\note\A();
                   $note->loadFromId($_REQUEST['note_id']);
                } else {
                    $notes = $a->getNotes();
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
        case 'cadastraltable':
            $cadastralcoll = $a->getCadastalColl();
            $cadastralcoll->loadAll($_REQUEST);
            $response =array(
                'sEcho'=>  intval($_REQUEST['sEcho']),
                'iTotalRecords'=>$cadastralcoll->countAll(),
                'iTotalDisplayRecords'=>$cadastralcoll->count(),
                'sColumns'=>  implode(',',$cadastralcoll->getColumns()),
                'aaData'=>array()
            );
            
            foreach($cadastralcoll->getItems() as $cadastral) :
                $datarow = array();
                $datarow[]=intval($cadastral->getData('objectid'));
                $datarow[]=$cadastral->getData('foglio');
                $datarow[]=$cadastral->getData('particella');
                $datarow[]=floatval($cadastral->getData('sup_tot_cat'));
                $datarow[]=floatval($cadastral->getData('sup_tot'));
                $datarow[]=floatval($cadastral->getData('sup_bosc'));
                $datarow[]=floatval($cadastral->getData('sum_sup_non_bosc'));
                $datarow[]=floatval($cadastral->getData('porz_perc'));
                $datarow[]=$cadastral->getData('note');
                ob_start();
                ?>
        <div class="table_actions">
            <a href="bosco.php?task=forma&action=cadastratabledelete&id=<?php echo $a->getData('objectid');?>&elementid=<?php echo intval($cadastral->getData('objectid'));?>"><img class="actions delete" src="images/empty.png" title="Cancella"/></a>
        </div>
                <?php $datarow[]=  ob_get_clean();
                $response['aaData'][]=$datarow;
            endforeach;
            header('Content-type: application/json');
            echo Zend_Json::encode($response);
            exit;
        break;
        case 'cadastratableedit' :
            $cadastral = new forest\attribute\Cadastral();
            if (is_numeric($_REQUEST['elementid'])) {
                $cadastral->loadFromId($_REQUEST['elementid']);
                $cadastral->setData($_REQUEST['value'],$_REQUEST['field']);
                $cadastral->update();
            } else {
                $cadastralcoll = $a->getCadastalColl();
                $cadastral = $cadastralcoll->addItem();
                try{
                    $cadastral->insert();
                } catch (Exception $e) {}
            }
            
            exit;
        break;
        case 'cadastratabledelete' :
            $cadastral = new forest\attribute\Cadastral();
            $cadastral->loadFromId($_REQUEST['elementid']);
            $cadastral->delete();
            exit;
        break;
        case 'cadastratablesummary' :
            $cadastralcoll = $a->getCadastalColl();
            header('Content-type: application/json');
            echo Zend_Json::encode($cadastralcoll->getSummary());
            exit;
        break;
        case 'updatesurface':
            $cadastralcoll = $a->getCadastalColl();
            $data = $cadastralcoll->getSummary();
            header('Content-type: application/json');
            echo Zend_Json::encode($data['sum_sup_tot_cat']);
            exit;
        break;
        case 'update':
            if($_REQUEST['codice_bosco']== '')
                $formErrors->addError(FormErrors::required,'codice_bosco','bosco');
            if($_REQUEST['cod_part']== '')
                $formErrors->add(FormErrors::required,'cod_part','codice particella');
            if($_REQUEST['sup_tot'] != '' && !is_numeric($_REQUEST['sup_tot']))
                $formErrors->addError(FormErrors::valid_float,'sup_tot','superficie totale','f');
            if($_REQUEST['boscata_calcolo'] != '' && !is_numeric($_REQUEST['boscata_calcolo']))
                $formErrors->addError(FormErrors::valid_float,'boscata_calcolo','superficie boscata','f');
            if(!filter_var($_REQUEST['ap'],FILTER_VALIDATE_INT))
                $formErrors->addError(FormErrors::valid_int,'ap','altitudine prevalente');
            if($_REQUEST['improduttivi_calcolo'] != '' && !is_numeric($_REQUEST['improduttivi_calcolo']))
                $formErrors->addError(FormErrors::valid_float,'improduttivi_calcolo','superficie improduttiva','f');
            if($_REQUEST['prod_non_bosc_calcolo'] != '' && !is_numeric($_REQUEST['prod_non_bosc_calcolo']))
                $formErrors->addError(FormErrors::valid_float,'prod_non_bosc_calcolo','superficie produttiva non boscata','f');
            if($_REQUEST['pp'] != '' && !is_numeric($_REQUEST['pp']))
                $formErrors->addError(FormErrors::valid_float,'pp','pendenza prevalente','f');
            if(!filter_var($_REQUEST['sup'],FILTER_VALIDATE_INT))
                $formErrors->addError(FormErrors::valid_int,'sup','Sottoparticella estesa su %','f');
            $formErrors->setOkMessage(' I dati sono stati salvati alle '.  strftime('%k:%M:%S del %d %b'));
            if ($formErrors->count() == 0) {
                $a->setData($_REQUEST);
                $a->update();
                $log->setData(array(
                            'user_id'=>$user->getData('id'),
                            'username'=>$user->getData('username'),
                            'description'=>'Modifica della Scheda A '.$a->getData('proprieta').' '.$a->getData('cod_part'),
                            'objectid'=>$a->getData('objectid'),
                        ));
            }
            $formErrors->getJsonError ();
            exit;
        break;
        
    }
}
if (key_exists('deletenote', $_REQUEST)) {
    $notaa = new \forest\attribute\note\A();
    $notaa->loadFromId($_REQUEST['deletenote']);
    $notaa->delete();
}
