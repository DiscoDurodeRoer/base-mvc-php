<?php

class Router
{
  private $routes;

  public function register(Route $route)
  {
    $this->routes[] = $route;
  }

  public function handleRequest(string $request)
  {

    $matches = [];
    foreach ($this->routes as $route) {
      if (preg_match($route->path, $request, $matches)) {

        array_shift($matches);

        require_once("../app/controllers/" . $route->controller . ".php");

        $params = $matches;
        
        $controller = new $route->controller;

        call_user_func_array(
          [$controller, $route->method],
          $params
        );

        return;
      }
    }
    throw new RuntimeException("The request '$request' did not match any route.");
  }

}
