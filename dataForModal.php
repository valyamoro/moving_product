<?php
require_once __DIR__ . '/vendor/autoload.php';

$session = new \App\core\Http\Session();
$session->start(true);

$request = new \App\core\Http\Request();
?>
