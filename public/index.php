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
$router->addRoute('posts', ['controller' => 'Posts', 'action' => 'index']);
$router->addRoute('{controller}/{action}');
$router->addRoute('{controller}/{id:\d+}/{action}');
$router->addRoute('admin/{controller}/{action}', ['namespace' => 'Admin']);

// echo "<pre>";

// echo htmlspecialchars(print_r($router->getRoutes(), true));

// // Match the requested route
// $url = $_SERVER['QUERY_STRING'];

// if ($router->matchRoute($url)) {
//   echo '<pre>';
//   var_dump($router->getParams());
//   echo '</pre>';
// } else {
//   echo "No route found for URL '$url'";
// }

$router->dispatch($_SERVER['QUERY_STRING']);
