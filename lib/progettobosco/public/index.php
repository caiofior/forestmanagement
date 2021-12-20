<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Index page controller
 */
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$view = new Template(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$header = 'header'.DIRECTORY_SEPARATOR.'index.php';
$content = 'content'.DIRECTORY_SEPARATOR.'index.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
if ($user === false) {
    $header = 'general'.DIRECTORY_SEPARATOR.'header.php';
    $content = 'content'.DIRECTORY_SEPARATOR.'login.php';
    $sidebar = 'sidebar'.DIRECTORY_SEPARATOR.'login.php';
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
            $response[ $value]=  ob_get_clean();
            }
    }
    header('Content-type: application/json');
    echo Zend_Json::encode($response);
    exit;
} else if (key_exists('register', $_REQUEST) ) {
    $user_unique = false;
    $new_user = new User();
    
    try{
        $new_user->loadFromUsername($_REQUEST['username']);
    } catch (Exception $e) {
        if ($e->getCode()==1301130904)
            $user_unique = true;
        else  throw $e;
    }
    if($_REQUEST['username'] == '' ) {
       $formErrors->addError(FormErrors::required,'username','nome utente');       
    }
    else if(!filter_var($_REQUEST['username'], FILTER_VALIDATE_EMAIL)) {
       $formErrors->addError(FormErrors::valid_email,'username','nome utente');       
    }
    else if (!$user_unique) {
       $formErrors->addError(FormErrors::custom,'username','Nome utente già presente (<a href="#" class="password_recover">recupera password</a>)');       
    }
    if($_REQUEST['password'] == '' ) {
       $formErrors->addError(FormErrors::required,'password','password','f');       
    }
    else if(strlen($_REQUEST['password']) < 6 ) {
       $formErrors->addError(FormErrors::custom,'password','La password deve avere almeno sei caratteri','f');       
    }
    else if($_REQUEST['password'] !=  $_REQUEST['confirm_password']) {
       $formErrors->addError(FormErrors::custom,'password','Le due password non sono uguali');       
    }
    
    if ($formErrors->count() == 0) {
         
        $user=new User();
        
        $user->setData($_REQUEST['username'],'username');
        $user->setData($_REQUEST['message'],'message');
        $user->setData($_REQUEST['password'],'password_new');
        
        $user->insert();
        $log->setData(array(
            'user_id'=>$user->getData('id'),
            'username'=>$_REQUEST['username'],
            'description'=>'Creazione dell\'utente',
        ));
        $log->insert();
        ob_start();
        require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'mail'.DIRECTORY_SEPARATOR.'confirmation.php';
        $content = ob_get_clean();
        $mail = new Zend_Mail('UTF-8');
        $mail->setBodyText(strip_tags($content));
        $mail->setBodyHTML($content);
        $mail->setFrom($MAIL_ADMIN_CONFIG['from'], $MAIL_ADMIN_CONFIG['from_name']);
        $mail->addTo($_REQUEST['username'], $_REQUEST['username']);
        $mail->setSubject('Conferma iscrizione al sito '.$SITE_NAME);
        try{
            $mail->send(new Zend_Mail_Transport_Smtp($MAIL_ADMIN_CONFIG['server'], $MAIL_ADMIN_CONFIG));
        } catch (Exception $e) {
            $user->delete();
            $formErrors->addError(FormErrors::custom,'password','C\'è stato un problema durante la registrazione, prova in un secondo momento.');       
        }
    }
    $formErrors->setOkMessage('L\'utente è stato creato e ti è stata inviata una mail per confermare l\'indirizzo di posta');
    if (key_exists('xhr', $_REQUEST)) {
         $formErrors->getJsonError();
    }
} else if (key_exists('subscription_confirm', $_REQUEST)) {
    $user = new User();
    $content = 'content'.DIRECTORY_SEPARATOR.'confirmation_succesfull.php';
    try {
        $user->loadFromConformationCode($_REQUEST['subscription_confirm']);
    } catch (Exception $e) {
        $content = 'content'.DIRECTORY_SEPARATOR.'confirmation_failed.php';
    }
    if (is_numeric($user->getData('id'))) {
        if ($user->getData('confirmed'))
            $content = 'content'.DIRECTORY_SEPARATOR.'confirmation_alreadyconfirmed.php';
        else {
            $user->setData(true, 'active');
            $user->setData(true, 'confirmed');
            $user->update();
        }
    }
    
} else if (key_exists('recoverpassword', $_REQUEST)) {
    $user_unique = false;
    $new_user = new User();
    
    try{
        $new_user->loadFromUsername($_REQUEST['username']);
    } catch (Exception $e) {
        if ($e->getCode()==1301130904)
            $user_unique = true;
        else  throw $e;
    }
    if($_REQUEST['username'] == '' ) {
       $formErrors->addError(FormErrors::required,'username','nome utente');       
    }
    else if(!filter_var($_REQUEST['username'], FILTER_VALIDATE_EMAIL)) {
       $formErrors->addError(FormErrors::valid_email,'username','nome utente');       
    }
    else if ($user_unique) {
       $formErrors->addError(FormErrors::custom,'username','non trovo questo nome utente');       
    }
    $password =  $new_user->generatePassword();
    if($user_unique == false) {
        $new_user->update();
        ob_start();
        require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'mail'.DIRECTORY_SEPARATOR.'recoverpassword.php';
        $content = ob_get_clean();
        $mail = new Zend_Mail('UTF-8');
        $mail->setBodyText(strip_tags($content));
        $mail->setBodyHTML($content);
        $mail->setFrom($MAIL_ADMIN_CONFIG['from'], $MAIL_ADMIN_CONFIG['from_name']);
        $mail->addTo($_REQUEST['username'], $_REQUEST['username']);
        $mail->setSubject('Recupero password del sito '.$SITE_NAME);
        try{
            $mail->send(new Zend_Mail_Transport_Smtp($MAIL_ADMIN_CONFIG['server'], $MAIL_ADMIN_CONFIG));
        } catch (Exception $e) {
            $user->delete();
            $formErrors->addError(FormErrors::custom,'password','C\'è stato un problema durante la registrazione, prova in un secondo momento.');       
        }
        $formErrors->setOkMessage('Ti è stata inviata una mail con una nuova password, accedi al tuo profilo e potrai modificarla');
    }
    if (key_exists('xhr', $_REQUEST)) {
         $formErrors->getJsonError();
    }
}

$view->controler = basename(__FILE__);
$view->user = $user;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'login.php'
      )
    );
echo $view->render('Jungleland10.php');