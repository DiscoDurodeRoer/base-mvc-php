<?php

class CategoryController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("Category");
    }

    function display($id_cat_parent = null)
    {
        $params = array();

        if ($id_cat_parent) {
            $params['id_cat_parent'] = intval(filter_var($id_cat_parent, FILTER_SANITIZE_NUMBER_INT));
        }

        $data = $this->model->get_categories($params);

        if(isModeDebug()){
            writeLog(INFO_LOG, "CategoryController/display", json_encode($data));
        }

        $this->view("CategoryView", $data);
    }
}
