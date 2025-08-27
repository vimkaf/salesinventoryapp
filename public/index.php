<?php
require_once '../engine/ignition.php';
require '../vendor/autoload.php';
require_once '../config/site_settings.php';


if (ENV === 'dev') {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}


//Init Core Library
$init = new Core;
