<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages session login
 */
/**
 * @global FormErrors $formErrors
 */
 $formErrors = new FormErrors();
 $authAdapter = User::getAuthAdapter();
 $auth = Zend_Auth::getInstance();
 $session = $auth->getStorage()->read();
 $user = false;
 if (key_exists('login', $_REQUEST) ) {
     $authAdapter->setIdentity($_REQUEST['username']);
     $authAdapter->setCredential($_REQUEST['password']);
     try {
     if ($auth->authenticate($authAdapter)->isValid()) { 
        $userdata = get_object_vars($authAdapter->getResultRowObject(null, 'password'));
        $authStorage = $auth->getStorage();  
        $authStorage->write(array('user_id'=>$userdata['id']));
        $user = new User();
        $user->loadFromId($userdata['id']);
     }
     else
         $formErrors->addError(FormErrors::custom,'username','Nome utente o password errati');
     } catch (Exception $e) {
         $formErrors->addError(FormErrors::custom,'username','Nome utente o password errati');
     }
     if (key_exists('xhr', $_REQUEST)) {
         $formErrors->getJsonError();
     }
     
 }
 else if (key_exists('logout', $_REQUEST)) {
    $auth->clearIdentity();
    header('Location: '.$BASE_URL);
    exit;
 }
 else if (isset($session['user_id']) && is_numeric($session['user_id'])) {
     $user = new User();
     try{
     $user->loadFromId($session['user_id']);
     } catch (Exception $e) {
         session_destroy();
     }
  } else if (
          key_exists ('TEST_FOREST', $GLOBALS) &&
          key_exists ('id', $_REQUEST) &&
          $GLOBALS['TEST_FOREST'] == $_REQUEST['id']
          ) {
     $user = new User();
     $authStorage = $auth->getStorage();
     $authStorage->write(array('user_id'=>0));
  }
 