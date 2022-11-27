<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Comprese page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$header = 'header'.DIRECTORY_SEPARATOR.'comprese.php';
$content = 'content'.DIRECTORY_SEPARATOR.'comprese.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
    $_REQUEST=array();
}
$forest = new forest\Forest();
if (key_exists('id', $_REQUEST))
    $forest->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        
    }
}
if (key_exists('compresa', $_REQUEST)) {
    if (key_exists('add', $_REQUEST)) {
        if (substr($_REQUEST['add'], 0, 1) == 'a') {
            $workingcircle = new \forest\WorkingCircle();
            try{
            $workingcircle->loadFromId($_REQUEST['compresa']);
            $forma = new \forest\entity\A();
            $forma->loadFromId(substr($_REQUEST['add'], 1));
            $workingcircle->addFormA($forma);
            } catch (Exception $e) {
                switch ($e->getCode()) {
                    case '0905131149':
                    case '1705130906':
                    break;
                    default : 
                        throw $e;
                    break;
                }
            }
        }
    }
    else if (key_exists('remove', $_REQUEST)) {
        if (substr($_REQUEST['remove'], 0, 1) == 's') {
            $workingcircle = new \forest\WorkingCircle();
            $workingcircle->loadFromId($_REQUEST['compresa']);
            $forma = new \forest\entity\A();
            $forma->loadFromId(substr($_REQUEST['remove'], 1));
            $workingcircle->removeFormA($forma);
        }
    }
    else if (key_exists('todo', $_REQUEST) && $_REQUEST['todo'] != '') {
            $workingcircle = new \forest\WorkingCircle();
            $workingcircle->loadFromId($_REQUEST['compresa']);
            $acoll = $forest->getAColl();
            if (!key_exists('search', $_GET))
                $_GET['search']=null;
            if (!key_exists('parameter', $_GET))
                $_GET['parameter']=null;
            if (!key_exists('operator', $_GET))
                $_GET['operator']=null;
            if (!key_exists('value', $_GET))
                $_GET['value']=null;
            
                                                           
        if ($_REQUEST['todo']='add_all') {
            $acoll->loadAll(
                    array(
                'search'=>$_GET['search'],
                'parameter'=>$_GET['parameter'],
                'operator'=>$_GET['operator'],
                'value'=>$_GET['value'],
                'associated_compresa'=>false
            )
            );
             foreach($acoll->getItems() as $a) 
                 try {
                 $workingcircle->addFormA($a);
                 } catch (Exception $e)
                 { 
                    if ($e->getCode() != '0905131149')
                    throw $e;
                 }
        }
        else if ($_REQUEST['todo']='removeall_all') {
            $acoll->loadAll(
                    array(
                'search'=>$_GET['search'],
                'parameter'=>$_GET['parameter'],
                'operator'=>$_GET['operator'],
                'value'=>$_GET['value'],
                'associated_compresa'=>true
            )
            );
             foreach($acoll->getItems() as $a) 
                 $workingcircle->removeFormA($a);
        }
    }
}
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
          'footer'.DIRECTORY_SEPARATOR.'comprese.php'
      )
    );
echo $view->render('Jungleland10_1col.php');