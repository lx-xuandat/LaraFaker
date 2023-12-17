<?php

use App\Controllers\Admin\Auth\LoginController;
use App\Controllers\Customer\HomeController;
use App\Cores\Application;

$router = Application::$app->router;

$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [LoginController::class, 'getLogin']);
$router->post('/login', [LoginController::class, 'postLogin']);
