<?php

class SearchController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("Search");
    }

    function proccess_search()
    {

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $searchProcess = str_replace(" ", "+", $_POST['search']);
    
            if (isModeDebug()) {
                writeLog(INFO_LOG, "SearchController/proccess_search", $searchProcess);
            }

            redirect_to_url("/base-mvc-php/busqueda/" . $searchProcess);
        }
    }

    function display($searchedProccess)
    {
        $params = array(
            "searched" => $searchedProccess
        );

        $data = $this->model->search_topics($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "SearchController/display", json_encode($data));
        }

        $this->view("SearchView", $data);
    }
}
