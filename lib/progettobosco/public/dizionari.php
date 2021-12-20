<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Dizionari page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$message = '';
$content = 'content'.DIRECTORY_SEPARATOR.'dizionari.php';
if (isset( $_REQUEST['scheda'] ) )  
    $content = 'content'.DIRECTORY_SEPARATOR.'dizionari1.php';
$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->controler = basename(__FILE__);
$view->message = $message;
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'CONTENT' => array(
          'general'.DIRECTORY_SEPARATOR.'menu.php',
          $content
      ),
     'FOOTER' => 'general'.DIRECTORY_SEPARATOR.'footer.php',
    );
echo $view->render('main.php');