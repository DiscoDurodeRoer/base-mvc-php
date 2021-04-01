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

        header("Location: " . BASE_URL_ROUTE . "admin/categorias");
    }

    function back()
    {
        header("Location: " . BASE_URL_ROUTE);
    }
}
