<?php

// CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
// CORS

require_once __DIR__ . '/vendor/autoload.php';

use App\Router\Router;
use App\Controllers\HomeController;

($router = new Router())
    ->setGlobalParametersPattern([
        'id' => '[0-9]+',
        'uuid' => '[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}',
    ]);

$router->get('/', [HomeController::class, 'index'])
    ->setName('index');

$router->get('/about', [HomeController::class, 'about'])
    ->setName('about');

$router->get('/users/{cpf?}', [HomeController::class, 'users'])
    ->setName('users')
    ->setParameterPattern('cpf', '[0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2}');

$router->dispatch();
