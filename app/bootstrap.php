<?php

if (!defined('APP_ROOT_PATH')) {
    define('APP_ROOT_PATH', __DIR__);
}

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();
