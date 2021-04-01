<?php

class AdminController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("Admin");
    }

    function display()
    {
        isLogged();

        header("Location: /base-mvc-php/admin/categorias");
    }

    function back()
    {
        header("Location: /base-mvc-php");
    }
}
