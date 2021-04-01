<?php

class LoginController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("Login");
    }

    function display()
    {
        $data = array();

        $data['display_login'] = true;

        $this->view("LoginView", $data);
    }

    function login()
    {

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            $params = array(
                'nick_email' => $_POST['nick_email'],
                'pass' => $_POST['pass']
            );

            $data = $this->model->checkLogin($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Login/login", json_encode($data));
            }

            if ($data['success']) {
                if ($data['user']) {
                    prepareDataLogin($data['user']);
                }
                redirect_to_url(BASE_URL);
            } else {
                $this->view("LoginView", $data);
            }
        }
    }

    function display_remember()
    {

        $data = array();

        $data['display_recover_password'] = true;

        $this->view("LoginView", $data);
    }

    function remember()
    {


        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {


            $data = array();

            $params = array(
                'email' => $_POST['email']
            );

            $data = $this->model->sendNotificationRememeber($params);

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Login/remember", json_encode($data));
            }

            $this->view("LoginView", $data);
        }
    }
}
