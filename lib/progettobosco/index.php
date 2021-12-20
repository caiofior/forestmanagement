<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Redirect to public dir
 */
require __DIR__.DIRECTORY_SEPARATOR.'config.php';
header('Location: '.$BASE_URL);