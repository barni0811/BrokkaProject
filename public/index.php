<?php

use Controller\VehicleController;
use Controller\PortfolioController;

spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/../src/';
    $classPath = str_replace('\\', '/', $class);
    require_once $baseDir . $classPath . '.php';
});

$uri = $_SERVER['REQUEST_URI'];

if (preg_match('#^/gepjarmu/rendszam/([A-Z0-9]+)$#', $uri, $matches)) {
    $plate = $matches[1];
    $controller = new VehicleController();
    $controller->handle($plate);
} elseif ($uri === '/ugyfelek') {
    $controller = new PortfolioController();
    $controller->handle();
} else {
    http_response_code(404);
    echo 'Not Found';
}