<?php

class AdminCategoryController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("AdminCategory");
    }

    function display($page = 1)
    {
        isLogged();

        $params = array(
            'mode' => ALL_CATEGORIES,
            'page' => intval(filter_var($page, FILTER_SANITIZE_NUMBER_INT))
        );

        $data = $this->model->get_categories($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminCategoryController/display", json_encode($data));
        }

        $this->view("AdminCategoryView", $data);
    }


    function display_create()
    {

        isLogged();

        $params = array(
            'mode' => ONLY_PARENTS
        );

        $data = $this->model->get_categories($params);

        $data['display_create'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminCategoryController/display_create", json_encode($data));
        }

        $this->view("AdminCategoryView", $data);
    }

    function create_category()
    {

        isLogged();

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
            $params = array(
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'parent_cat' => isset($_POST['parent_cat']) ? intval(filter_var($_POST['parent_cat'], FILTER_SANITIZE_NUMBER_INT)) : 1
            );

            $data = $this->model->create_category($params);

            $params = array(
                'mode' => ALL_CATEGORIES,
                'page' => 1
            );

            $data_categories = $this->model->get_categories($params);

            $data['categories'] = $data_categories['categories'];
            $data["pag"] = $data_categories['pag'];
            $data['last_page'] = ceil($data_categories['num_elems'] / NUM_ITEMS_PAG);
            $data["num_elems"] = $data_categories['num_elems'];
            $data['url_base'] = $data_categories['url_base'];

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminCategoryController/create_category", json_encode($data));
            }

            $this->view("AdminCategoryView", $data);
        }
    }

    function display_edit($id_category)
    {
        isLogged();

        $params = array(
            'id_category' => $id_category
        );

        $data = $this->model->get_category($params);

        $params = array(
            'mode' => ONLY_PARENTS
        );

        $data['categories'] = $this->model->get_categories($params)['categories'];

        $data['display_edit'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminCategoryController/display_edit", json_encode($data));
        }

        $this->view("AdminCategoryView", $data);
    }

    function edit_category()
    {

        isLogged();

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {


            $params = array(
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'parent_cat_ori' => $_POST['parent_cat_ori'],
                'parent_cat' => isset($_POST['parent_cat']) ? filter_var($_POST['parent_cat'], FILTER_SANITIZE_NUMBER_INT) : null,
                'id' => filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT)
            );


            $data = $this->model->edit_category($params);

            $params = array(
                'mode' => ALL_CATEGORIES,
                'page' => 1
            );

            $data_categories = $this->model->get_categories($params);

            $data['categories'] = $data_categories['categories'];
            $data["pag"] = $data_categories['pag'];
            $data['last_page'] = ceil($data_categories['num_elems'] / NUM_ITEMS_PAG);
            $data["num_elems"] = $data_categories['num_elems'];
            $data['url_base'] = $data_categories['url_base'];

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminCategoryController/edit_category", json_encode($data));
            }

            $this->view("AdminCategoryView", $data);
        }
    }

    function delete_category($id_category)
    {

        isLogged();

        $params = array(
            'id_category' => filter_var($id_category, FILTER_SANITIZE_NUMBER_INT)
        );

        $data = $this->model->delete_category($params);

        $params = array(
            'mode' => ALL_CATEGORIES,
            'page' => 1
        );

        $data_categories = $this->model->get_categories($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminCategoryController/delete_category", json_encode($data_categories));
        }

        $data['categories'] = $data_categories['categories'];
        $data["pag"] = $data_categories['pag'];
        $data['last_page'] = ceil($data_categories['num_elems'] / NUM_ITEMS_PAG);
        $data["num_elems"] = $data_categories['num_elems'];
        $data['url_base'] = $data_categories['url_base'];

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminCategoryController/delete_category", json_encode($data));
        }

        $this->view("AdminCategoryView", $data);
    }
}
