<?php

class Route
{
    public $path;
    public $controller;
    public $method;

    public function __construct(
      string $path, 
      string $controller, 
      string $method
      ) {
        $this->path = $path;
        $this->controller = $controller;
        $this->method = $method;
    }
}