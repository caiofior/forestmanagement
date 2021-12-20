<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Descrizione page contoller
 */
$response = array();
$a = new \forest\entity\A();
$a->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'generate':
            $response = $a->generateDescription();
        break;
    }
}
header('Content-type: application/json');
echo Zend_Json::encode($response);
exit;
