<?php

class BreadCumb {

    private $display;
    private $url;
    private $enabled;
    private $icon;

    function __construct($display, $url, $icon, $enabled)
    {
        $this->display = $display;
        $this->url = $url;
        $this->icon = $icon;   
        $this->enabled = $enabled;
    }

    function __get($propiedad)
    {
        if(property_exists($this, $propiedad)){
            return $this->$propiedad;
        }
    }

    function __set($propiedad, $valor){
        if(property_exists($this, $propiedad)){
            $this->$propiedad = $valor;
        }
    }


}
