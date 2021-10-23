<?php

namespace Core;

class Router
{
  /**
   * Associative Array of routes (The Routing Table);
   * @var array
   */
  protected $routes = [];

  /**
   * Parameters from the matched route
   *
   * @var array
   */
  protected $params = [];

  /**
   * Add a route to the routing table
   * @param string $route The route URL
   * @param array Parameters (Controller, Action, etc);
   * 
   * @return void;
   */
  public function addRoute(string $route, array $params = []): void
  {
    // Convert the route to a regular expression: escape the forward slashes
    $route = preg_replace('/\//', '\\/', $route);

    // Convert variables 
    $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);


    // Convert variables with custom regular expressions e.g. {id:\d+}
    $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);


    // Add start and end delimiters, and case insensitive flag 
    $route = '/^' . $route . '$/i';

    $this->routes[$route] = $params;
  }

  /**
   * Get all the routes from the routing table
   * 
   * @return array
   */

  public function getRoutes(): array
  {
    return $this->routes;
  }

  /**
   * Match the route to the routes in the routing table, setting the $params
   * property if a route is found
   * 
   * @param string $url
   * @return boolean
   */
  public function matchRoute(string $url): bool
  {


    foreach ($this->routes as $route => $params) {
      if (preg_match($route, $url, $matches)) {
        // Get named capture group values;

        foreach ($matches as $key => $match) {
          if (is_string($key)) {
            $params[$key] = $match;
          }
        }

        $this->params = $params;
        return true;
      }
    }

    return false;
  }

  /**
   * Get the value of params
   * 
   * @return array
   */
  public function getParams(): array
  {
    return $this->params;
  }

  /**
   * Undocumented function
   *
   * @param string $url
   * @return void
   */
  public function dispatch(string $url): void
  {

    $url = $this->removeQueryStringVariables($url);

    if ($this->matchRoute($url)) {
      $controller = $this->params['controller'];
      $controller = $this->convertToPascalCase($controller);
      // $controller = "App\Controllers\\$controller";
      $controller = $this->getNamespace() . $controller;


      if (class_exists($controller)) {
        $controller_object = new $controller($this->params);

        $action = $this->params['action'];
        $action = $this->convertToCamelCase($action);

        if (is_callable([$controller_object, $action])) {
          $controller_object->$action();
        } else {
          echo "Method $action (in controller $controller) not found";
        }
      } else {
        echo "Controller class $controller not found";
      }
    } else {
      echo 'No route matched.';
    }
  }

  /**
   * Convert a string with hyphens to PascalCase
   *
   * @param string $string
   * @return string
   */
  public function convertToPascalCase(string $string): string
  {
    return str_replace(" ", "", ucwords(str_replace("-", " ", $string)));
  }

  /**
   * Convert a string with hyphens to camelCase
   *
   * @param string $string
   * @return string
   */
  public function convertToCamelCase(string $string): string
  {
    return lcfirst($this->convertToPascalCase($string));
  }

  /**
   * Converts the first ? to a & when passed through a $_SERVER variable.
   *
   * @param string $url
   * @return string
   */
  protected function removeQueryStringVariables($url)
  {
    if ($url != '') {
      $parts = explode('&', $url, 2);

      if (strpos($parts[0], '=') === false) {
        $url = $parts[0];
      } else {
        $url = '';
      }
    }

    return $url;
  }


  protected function getNamespace()
  {
    $namespace = 'App\Controllers\\';

    if (array_key_exists('namespace', $this->params)) {
      $namespace .= $this->params['namespace'] . '\\';
    }

    return $namespace;
  }
}
