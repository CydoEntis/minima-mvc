<?php

// Autoloader
spl_autoload_register(function ($class) {
    $root = dirname(__DIR__); //Get the parent directory;
    $file = $root . "/" . str_replace("\\", "/", $class) . ".php";
    if (is_readable($file)) {
        require $root . "/" . str_replace("\\", "/", $class) . ".php";
    }
});

use Core\Router;

$router = new Router();

// Add Routes
$router->addRoute('', ['controller' => 'Home', 'action' => 'index']);
$router->addRoute('{controller}/{action}');
$router->addRoute('{controller}/{id:\d+}/{action}');
$router->addRoute('admin/{controller}/{action}', ['namespace' => 'Admin']);


$router->dispatch($_SERVER['QUERY_STRING']);
