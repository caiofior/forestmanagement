<?php
$x = new \forest\entity\x\X();
/*if (key_exists('id', $_REQUEST))
    $x->loadFromId ($_REQUEST['id']);*/
switch ($x->getData('tipo_ril')) {
    //default;
    case 2 :
        require __DIR__.DIRECTORY_SEPARATOR.'edit_ias.php';
    break;
    //default;
    case 1 :
        require __DIR__.DIRECTORY_SEPARATOR.'edit_ict.php';
    break;
    //default;
    case 3 :
        require __DIR__.DIRECTORY_SEPARATOR.'edit_ird.php';
    break;
    //default;
    case 4 :
        require __DIR__.DIRECTORY_SEPARATOR.'edit_irs.php';
    break;
    default;
    case 5 :
        require __DIR__.DIRECTORY_SEPARATOR.'edit_irp.php';
    break;
}
