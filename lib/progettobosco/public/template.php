<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Index page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));

if ($user === false)
    $content = 'general'.DIRECTORY_SEPARATOR.'login.php';
$view->controler = basename(__FILE__);
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'MENU' => 'general'.DIRECTORY_SEPARATOR.'Jungleland10_menu.php',
      'CONTENT' => 'general'.DIRECTORY_SEPARATOR.'Jungleland10_main.php',
      'SIDEBAR' => 'general'.DIRECTORY_SEPARATOR.'Jungleland10_sidebar.php',
      'FOOTER' => 'general'.DIRECTORY_SEPARATOR.'Jungleland10_footer.php'
    );
echo $view->render('Jungleland10.php');