<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Dati catastali page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$header = 'header'.DIRECTORY_SEPARATOR.'daticat.php';
$content = 'content'.DIRECTORY_SEPARATOR.'daticat.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
    $_REQUEST=array();
}
$forest = new forest\Forest();
$forest->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'vercalc' :
            if (key_exists('confirmed',$_REQUEST) && 
                    key_exists('method',$_REQUEST) &&
                    is_numeric($_REQUEST['method'])
                    ) {
                header('Content-type: application/json');
                echo Zend_Json::encode($forest->surfaceVerifyCalc($_REQUEST['method']));
            }
            else
                require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.
                    'blocks'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.
                    'daticat'.DIRECTORY_SEPARATOR.'vercalc.php';
            exit;
        break;
        case 'surfacerecalc' :
            if (key_exists('confirmed', $_REQUEST))
                $forest->surfaceRecalc();
            exit;
        break;
        case 'autocomplete_code_part' :
            $response=array();
            $acoll = $forest->getAColl();
             $acoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term']
            ));
            foreach($acoll->getItems() as $a) {
                $data = array(
                    'id'=>$a->getData('cod_part'),
                    'value'=>$a->getData('cod_part')
                );
                $response[]=$data;
            }
            header('Content-type: application/json');
            echo Zend_Json::encode($response);
            exit;
        break;
        case 'cadastratabledelete':
            $cadrastal = new \forest\attribute\Cadastral();
            $cadrastal->loadFromId($_REQUEST['elementid']);
            $cadrastal->delete();
        exit;
        break;
        case 'cadastratableedit':
            $cadrastal = new \forest\attribute\Cadastral();
            if (is_numeric($_REQUEST['elementid'])) {
                $cadrastal->loadFromId($_REQUEST['elementid']);
                $cadrastal->setData($_REQUEST['value'],$_REQUEST['field']);
                $cadrastal->update();
            } else {
                $acoll = $forest->getAColl();
                $acoll->loadAll();
                $cadastralcoll = $acoll->getFirst()->getCadastalColl();
                $cadastral = $cadastralcoll->addItem();
                $cadastral->insert();

            }
            exit;
        break;
        case 'cadastraltable':
            $cadastralcoll = $forest->getAttributeColl(new \forest\attribute\CadastralColl());
            $cadastralcoll->loadAll($_REQUEST);
            $response =array(
                'sEcho'=>  intval($_REQUEST['sEcho']),
                'iTotalRecords'=>$cadastralcoll->countAll(),
                'iTotalDisplayRecords'=>$cadastralcoll->count(),
                'sColumns'=>  implode(',',$cadastralcoll->getColumns()),
                'aaData'=>array()
            );
            foreach($cadastralcoll->getItems() as $cadastral) {
                $datarow = array();
                $datarow[]=intval($cadastral->getData('objectid'));
                $datarow[]=$cadastral->getData('foglio');
                $datarow[] = $cadastral->getData('particella');
                $datarow[] = floatval($cadastral->getData('sup_tot_cat'));
                $datarow[] = floatval($cadastral->getRawData('catasto_sup_tot'));
                $datarow[] = floatval($cadastral->getRawData('sup_bosc'));
                $datarow[] = floatval($cadastral->getRawData('non_boscata'));
                $datarow[] = floatval($cadastral->getRawData('sum_sup_non_bosc'));
                $datarow[] = floatval($cadastral->getRawData('porz_perc'));
                $datarow[] = $cadastral->getRawData('note');
                ob_start(); ?>
<input class="code_part" name="code_part" value="<?php echo $cadastral->getRawData('cod_part');?>"/>                
                <?php 
                $datarow[] = ob_get_clean();
                $datarow[] = floatval($cadastral->getRawData('schede_a_sup_tot'));
                $datarow[] = $cadastral->getRawData('calcolo');
                $datarow[] = $cadastral->getRawData('i1');
                $datarow[] = $cadastral->getRawData('i2');
                ob_start(); ?>
<input type="checkbox" <?php echo ($cadastral->getRawData('i3') != 'f' ? 'checked="checked"' : '') ?>  name="i3" value="1"/>
<?php 
                $datarow[] = ob_get_clean();
                ob_start(); ?>
<input type="checkbox" <?php echo ($cadastral->getRawData('i4') != 'f' ? 'checked="checked"' : '') ?> name="i4" value="1"/>
<?php 
                $datarow[] = ob_get_clean();
                ob_start(); ?>
<input type="checkbox" <?php echo ($cadastral->getRawData('i5') != 'f' ? 'checked="checked"' : '') ?> name="i5" value="1"/>
<?php 
                $datarow[] = ob_get_clean();
                ob_start(); ?>
<input type="checkbox" <?php echo ($cadastral->getRawData('i6') != 'f' ? 'checked="checked"' : '') ?> name="i6" value="1"/>
<?php 
                $datarow[] = ob_get_clean();
                ob_start(); ?>
<input type="checkbox" <?php echo ($cadastral->getRawData('i7') != 'f' ? 'checked="checked"' : '') ?> name="i7" value="1"/>
<?php 
                $datarow[] = ob_get_clean();
                $datarow[] = $cadastral->getRawData('i8');
                $datarow[] = $cadastral->getRawData('i21');
                $datarow[] = $cadastral->getRawData('i22');
                ob_start();
                ?>
        <div class="table_actions">
            <a href="daticat.php?action=cadastratabledelete&id=<?php echo $forest->getData('objectid');?>&elementid=<?php echo $cadastral->getData('objectid');?>"><img class="actions delete" src="images/empty.png" title="Cancella"/></a>
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
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->user = $user;
$view->formErrors = $formErrors;
$view->controler = basename(__FILE__);
$view->message = $message;
$view->forest = $forest;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'daticat.php'
      )
    );
echo $view->render('Jungleland10.php');