<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Index page contoller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
if (key_exists('profile', $_REQUEST)) {
    if($_REQUEST['phone'] != '' && !filter_var($_REQUEST['phone'], FILTER_VALIDATE_REGEXP,array('options'=>array('regexp'=>'/[+ 0-9]{5,}/')))) {
       $formErrors->addError(FormErrors::custom,'phone','Indica un telefono valido ( +0-9) ');       
    }
    if($_REQUEST['web'] != '' && !filter_var($_REQUEST['web'], FILTER_VALIDATE_URL)) {
       $formErrors->addError(FormErrors::valid_url,'web','Indirizzo web');       
    }
    if($_REQUEST['facebook'] != '' && !filter_var($_REQUEST['facebook'], FILTER_VALIDATE_URL)) {
       $formErrors->addError(FormErrors::valid_url,'facebook','Profilo facebook');       
    }
    if($_REQUEST['google'] != '' && !filter_var($_REQUEST['google'], FILTER_VALIDATE_URL)) {
       $formErrors->addError(FormErrors::valid_url,'google','Profilo Google +');       
    }
    if($_REQUEST['address_province'] != '' && !filter_var($_REQUEST['address_province'], FILTER_VALIDATE_REGEXP,array('options'=>array('regexp'=>'/[A-Z]{2}/')))) {
       $formErrors->addError(FormErrors::custom,'address_province','Indica la sigla di una provincia');       
    }
    if($_REQUEST['address_zip'] != '' && !filter_var($_REQUEST['address_zip'], FILTER_VALIDATE_REGEXP,array('options'=>array('regexp'=>'/[0-9]{5}/')))) {
       $formErrors->addError(FormErrors::custom,'address_zip','CAP non valido');       
    }
    if ($formErrors->count() == 0) {
        $user->setData($_REQUEST);
        $user->update();
        $profile = $user->getProfile();
        $profile->setData($_REQUEST);
        $profile->update();
        $log->setData(array(
            'user_id'=>$user->getData('id'),
            'username'=>$user->getData('username'),
            'description'=>'Aggiornamento profilo',
        ));
        $log->insert();
    }
    $formErrors->setOkMessage('I dati del profilo sono stati salvati');
     if (key_exists('xhr', $_REQUEST)) {
         $formErrors->getJsonError();
     }
}
else if (key_exists('action', $_REQUEST) && $_REQUEST['action']=='remove') {
    $log->setData(array(
            'user_id'=>$user->getData('id'),
            'username'=>$user->getData('username'),
            'description'=>'Cancellazione profilo',
        ));
    $log->insert();
    $user->delete();
    $GLOBALS['auth']->clearIdentity();
    header('Location: '.$BASE_URL);
    exit;
}
else if (key_exists('modify_password', $_REQUEST)) {
    if($user->checkPassword($_REQUEST['old_password']))
        $formErrors->addError(FormErrors::custom,'old_password', 'la vecchia password è errata');
    if ($_REQUEST['new_password'] == '')
        $formErrors->addError(FormErrors::required,'new_password','la password','f');
    else if(strlen($_REQUEST['new_password']) < 6 )
       $formErrors->addError(FormErrors::custom,'password','la password deve avere almeno sei caratteri','f');       
    else if ($_REQUEST['new_password'] != $_REQUEST['confirm_password'])
        $formErrors->addError(FormErrors::custom,'new_password', 'le due password non coicidono');
    if ($formErrors->count() == 0) {
        $user->setData($_REQUEST['new_password'],'password_new');
        $user->update();
        $log->setData(array(
            'user_id'=>$user->getData('id'),
            'username'=>$user->getData('username'),
            'description'=>'Modifica password',
        ));
        $log->insert();
    }
    $formErrors->setOkMessage('Password modificata');
     if (key_exists('xhr', $_REQUEST)) {
         $formErrors->getJsonError();
     }
}
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$header = 'header'.DIRECTORY_SEPARATOR.'profile.php';
$content = 'content'.DIRECTORY_SEPARATOR.'profile.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if (key_exists('action',$_REQUEST) && $_REQUEST['action']=='password') {
    $content = 'content'.DIRECTORY_SEPARATOR.'password.php';
}
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
    $_REQUEST=array();
}
$view->controler = basename(__FILE__);
$view->user = $user;
$view->formErrors = $formErrors;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'profile.php'
      )
    );
echo $view->render('Jungleland10.php');