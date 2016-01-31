<?php

use Symfony\Component\Debug\Debug;

date_default_timezone_set('Europe/Paris');

// this is to use php -S localhost:8888 -t web/ web/index_dev.php
if (preg_match('/\.(?:png|jpg|jpeg|gif|css|js|woff|ttf)$/', $_SERVER["REQUEST_URI"])) {
    return false;
}

// This check prevents access to debug front controllers that are deployed by accident to production servers.
// Feel free to remove this, extend it, or make something more sophisticated.
// if (isset($_SERVER['HTTP_CLIENT_IP'])
//     || isset($_SERVER['HTTP_X_FORWARDED_FOR'])
//     || !in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1'))
// ) {
//     header('HTTP/1.0 403 Forbidden');
//     exit('You are not allowed to access this file. Check '.basename(__FILE__).' for more information.');
// }

require_once __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../app/bootstrap.php';

Debug::enable();
$app = new AppKernel;
$app->run();