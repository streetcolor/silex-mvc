<?php

ini_set('display_errors', 0);

require_once __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../app/bootstrap.php';

$app = new AppKernel;
$app->run();
