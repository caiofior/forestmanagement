<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * cartografia page contoller
 */
$view->forest = new forest\Forest();
if (key_exists('id', $_REQUEST)) {
    $view->forest->loadFromCode($_REQUEST['id']);
}
$content = 'content'.DIRECTORY_SEPARATOR.'bosco'.DIRECTORY_SEPARATOR.'cartografia.php';

