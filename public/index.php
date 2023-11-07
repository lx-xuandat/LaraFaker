<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');

define("ROOT", dirname(__DIR__));

require_once ROOT . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(ROOT);
$dotenv->load();

$app = require_once ROOT . '/bootstrap/app.php';

$app->run();
