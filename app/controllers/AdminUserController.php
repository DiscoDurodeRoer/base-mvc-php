<?php

class AdminUserController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("AdminUser");
    }

    function display($page = 1)
    {
        isLogged();

        $params = array(
            'page' => intval(filter_var($page, FILTER_SANITIZE_NUMBER_INT))
        );

        $data = $this->model->get_all_users($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminUserController/display", json_encode($data));
        }

        $this->view("AdminUserView", $data);
    }

    function ban_user($id_user)
    {
        isLogged();

        $params = array(
            'id_user' => intval(filter_var($id_user, FILTER_SANITIZE_NUMBER_INT))
        );

        $data = $this->model->ban_user($params);

        $params = array(
            'page' => 1
        );

        $users = $this->model->get_all_users($params);

        $data['users'] = $users['users'];
        $data['pag'] = $users['pag'];
        $data['last_page'] = $users['last_page'];
        $data['num_elems'] = $users['num_elems'];
        $data['url_base'] = $users['url_base'];

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminUserController/ban_user", json_encode($data));
        }

        $this->view("AdminUserView", $data);
    }

    function no_ban_user($id_user)
    {
        isLogged();

        $params = array(
            'id_user' => intval(filter_var($id_user, FILTER_SANITIZE_NUMBER_INT))
        );

        $data = $this->model->no_ban_user($params);

        $params = array(
            'page' => 1
        );

        $users = $this->model->get_all_users($params);

        $data['users'] = $users['users'];
        $data['pag'] = $users['pag'];
        $data['last_page'] = $users['last_page'];
        $data['num_elems'] = $users['num_elems'];
        $data['url_base'] = $users['url_base'];

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminUserController/no_ban_user", json_encode($data));
        }

        $this->view("AdminUserView", $data);
    }

    function no_act_user($id_user)
    {
        isLogged();

        $params = array(
            'id_user' => intval(filter_var($id_user, FILTER_SANITIZE_NUMBER_INT))
        );

        $data = $this->model->no_act_user($params);

        $params = array(
            'page' => 1
        );

        $users = $this->model->get_all_users($params);

        $data['users'] = $users['users'];
        $data['pag'] = $users['pag'];
        $data['last_page'] = $users['last_page'];
        $data['num_elems'] = $users['num_elems'];
        $data['url_base'] = $users['url_base'];

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminUserController/no_act_user", json_encode($data));
        }

        $this->view("AdminUserView", $data);
    }

    function act_user($id_user)
    {
        isLogged();

        $params = array(
            'id_user' => intval(filter_var($id_user, FILTER_SANITIZE_NUMBER_INT))
        );

        $data = $this->model->act_user($params);
        
        $params = array(
            'page' => 1
        );

        $users = $this->model->get_all_users($params);

        $data['users'] = $users['users'];
        $data['pag'] = $users['pag'];
        $data['last_page'] = $users['last_page'];
        $data['num_elems'] = $users['num_elems'];
        $data['url_base'] = $users['url_base'];

        if (isModeDebug()) {
            writeLog(INFO_LOG, "AdminUserController/act_user", json_encode($data));
        }

        $this->view("AdminUserView", $data);
    }
}
