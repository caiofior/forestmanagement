<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Tavole dendrometriche page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$header = 'header'.DIRECTORY_SEPARATOR.'tavole.php';
$content = 'content'.DIRECTORY_SEPARATOR.'tavole.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
    $_REQUEST=array();
}
$table = new \forest\attribute\Table();
if (key_exists('action', $_REQUEST) && $_REQUEST['action']=='xhr_update') {
                
            $response = array();
            $request = new RegexIterator(new ArrayIterator($_REQUEST), '/^[0-9]+$/',  RegexIterator::MATCH,  RegexIterator::USE_KEY); 
            foreach ($request as  $value) {
                $file_path = __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR;
                $file_path .= str_replace('_', DIRECTORY_SEPARATOR, $value).'.php';
                if (is_file($file_path)) {
                    ob_start();
                    require $file_path;
                    $response[$value]=  ob_get_clean();
                    }
            }
            header('Content-type: application/json');
            echo Zend_Json::encode($response);
            exit;
}
if (isset( $_REQUEST['codice'] ) )  {
    $table->loadFromId($_REQUEST['codice']);
    $content = 'content'.DIRECTORY_SEPARATOR.'tavoleManage.php';
}
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'table2data':
            $response =array();
            $table2coll = $table->getTable2Coll();
            $table2coll->loadAll($_REQUEST);
            
            $response =array(
                'sEcho'=>  intval($_REQUEST['sEcho']),
                'iTotalRecords'=>$table2coll->countAll(),
                'iTotalDisplayRecords'=>$table2coll->count(),
                'sColumns'=>  implode(',',$table2coll->getColumns()),
                'aaData'=>array()
            );
            foreach($table2coll->getItems() as $table2) {
                $datarow = array();
                $datarow[] = intval($table2->getData('objectid'));
                $datarow[] = $table2->getData('tariffa');
                $datarow[] = $table2->getData('d');
                $datarow[] = floatval($table2->getData('h'));
                $datarow[] = floatval($table2->getRawData('v'));
                ob_start(); ?>
        <div class="table_actions">
            <a href="daticat.php?action=cadastratabledelete&id=<?php echo $table->getData('objectid');?>&elementid=<?php echo $table2->getData('objectid');?>"><img class="actions delete" src="images/empty.png" title="Cancella"/></a>
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
$view->controler = basename(__FILE__);
$view->user = $user;
$view->table = $table;
$view->message = $message;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'tavole.php'
      )
    );
echo $view->render('Jungleland10.php');