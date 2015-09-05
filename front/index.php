<?php
ini_set('display_errors', 1);
define('ROOT_PATH', getcwd());
include '../core/core.php';
include 'config/config.php';
include 'config/loader.php';
include 'config/services.php';
include 'config/routes.php';
$app = new SF_BaseApp($config);
$app->start();