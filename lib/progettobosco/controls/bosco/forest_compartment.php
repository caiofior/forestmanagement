<?php
$header = 'header'.DIRECTORY_SEPARATOR.'particella.php';
$content = 'content'.DIRECTORY_SEPARATOR.'particella.php';
$sidebar = 'general'.DIRECTORY_SEPARATOR.'sidebar.php';
$a = new \forest\entity\A();
$a->loadFromId($_REQUEST['id']);
if (key_exists('deleteTab1', $_REQUEST)) {
    $bcoll = $a->getBColl();
    if ($bcoll->count() == 0) {
        $b = $bcoll->addItem ();
        $b->insert();
        $bcoll = $a->getBColl();
    }
    $b = $bcoll->getFirst();
    $b1coll = $b->getB1Coll();
    if($b1coll->count() == 0) {
        $b1 = $b1coll->addItem ();
        $b1->insert();
        $b1coll = $b->getB1Coll();
    }
    $b1 = $b1coll->getFirst();
    $b1->delete();
}  else if (key_exists('deleteTab2', $_REQUEST)) {
    $bcoll = $a->getBColl();
    if ($bcoll->count() == 0) {
        $b = $bcoll->addItem ();
        $b->insert();
        $bcoll = $a->getBColl();
    }
    $b = $bcoll->getFirst();
    $b2coll = $b->getB2Coll();
    if($b2coll->count() == 0) {
        $b2 = $b2coll->addItem ();
        $b2->insert();
        $b2coll = $b->getB2Coll();
    }
    $b2 = $b2coll->getFirst();
    $b2->delete();
} else if (key_exists('deleteTab3', $_REQUEST)) {
    $bcoll = $a->getBColl();
    if ($bcoll->count() == 0) {
        $b = $bcoll->addItem ();
        $b->insert();
        $bcoll = $a->getBColl();
    }
    $b = $bcoll->getFirst();
    $b3coll = $b->getB3Coll();
    if($b3coll->count() == 0) {
        $b3 = $b3coll->addItem ();
        $b3->insert();
        $b3coll = $b->getB3Coll();
    }
    $b3 = $b3coll->getFirst();
    $b3->delete();
} 
else if (key_exists('deleteTab4', $_REQUEST)) {
    $bcoll = $a->getBColl();
    if ($bcoll->count() == 0) {
        $b = $bcoll->addItem ();
        $b->insert();
        $bcoll = $a->getBColl();
    }
    $b = $bcoll->getFirst();
    $b4coll = $b->getB4Coll();
    if($b4coll->count() == 0) {
        $b4 = $b4coll->addItem ();
        $b4->insert();
        $b4coll = $b->getB4Coll();
    }
    $b4 = $b4coll->getFirst();
    $b4->delete();
} 
$view->a = $a;
$view->user = $user;
$view->formErrors = $formErrors;
$view->blocks = array(
      'HEADERS' => $header,
      'CONTENT' => $content,
      'SIDEBAR' => $sidebar,
      'FOOTER' => array(
          'general'.DIRECTORY_SEPARATOR.'footer.php',
          'footer'.DIRECTORY_SEPARATOR.'particella.php'
      )
    );
echo $view->render('Jungleland10_1col.php');
exit;
