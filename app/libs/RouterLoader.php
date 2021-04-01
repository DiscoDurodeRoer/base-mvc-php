<?php
class RouterLoader {
    
    private $routes = [
        [
            'url' => 'categoria-([0-9]+)', // regular expression.
            'controller' => 'CategoryController',
            'method' => 'display'
        ]
    ];
    
    function __construct()
    {
        
    }
    public function getRoutes()
    {
      return $this->routes;
    }
  
    public function getNamedRoute(string $name)
    {
      if(isset($this->routes[$name]))
      {
         return $this->routes[$name];
      }
      throw new Exception("Error Processing Request", 1);
    }

}

?>