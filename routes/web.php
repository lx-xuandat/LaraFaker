<?php

use App\Controllers\Admin\Auth\LoginController;
use App\Cores\Application;

$router = Application::$app->router;

$router->get('/login', [LoginController::class, 'getLogin']);
