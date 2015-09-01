<?php
ini_set('display_errors', 1);
include '../core/core.php';
include 'config/config.php';
include 'config/loader.php';
include 'config/services.php';
$app = new SF_BaseApp($config);
$app->start();