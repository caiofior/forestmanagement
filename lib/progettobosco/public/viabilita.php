<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Viabilità page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$header = 'header'.DIRECTORY_SEPARATOR.'viabilita.php';
$content = 'content'.DIRECTORY_SEPARATOR.'viabilita.php';
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
          'footer'.DIRECTORY_SEPARATOR.'viabilita.php'
      )
    );
echo $view->render('Jungleland10_1col.php');