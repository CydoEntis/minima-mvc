<?php

// Autoloader
require_once dirname(__DIR__) . "./vendor/autoload.php";

use Core\Router;

$router = new Router();

// Add Routes
$router->addRoute('', ['controller' => 'Home', 'action' => 'index']);
$router->addRoute('{controller}/{action}');
$router->addRoute('{controller}/{id:\d+}/{action}');
$router->addRoute('admin/{controller}/{action}', ['namespace' => 'Admin']);


$router->dispatch($_SERVER['QUERY_STRING']);
