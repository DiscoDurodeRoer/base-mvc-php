<?php

class UserController extends Controller
{

    private $model;

    function __construct()
    {
        $this->model = $this->model("User");
    }

    function display()
    {
        $data['registry'] = true;

        $this->view("UserView", $data);
    }

    function display_profile()
    {

        isLogged();

        $data = array();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->get_all_info_user($params);

        $data['profile'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UserController/display_profile", json_encode($data));
        }

        $this->view("UserView", $data);
    }

    function display_edit_profile()
    {

        isLogged();

        $data = array();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->get_all_info_user($params);

        $data['edit_profile'] = true;

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UserController/display_edit_profile", json_encode($data));
        }

        $this->view("UserView", $data);
    }

    function edit_profile()
    {

        isLogged();

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            $params = array(
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'nickname' => $_POST['nickname'],
                'email' => $_POST['email'],
                'id_user' => filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT)
            );

            $errors = $this->model->checkErrors($params);

            if (count($errors) === 0) {

                $params = array(
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'id_user' => $_POST['id_user'],
                    'name' => $_POST['name'],
                    'rol' => $_POST['rol'],
                    'surname' => $_POST['surname'],
                    'avatar' => $_POST['avatar']
                );

                $data = $this->model->edit_profile($params);
            } else {

                $data['info_user'] = array(
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'rol' => $_POST['rol'],
                    'id' => filter_var($_POST['id_user'], FILTER_SANITIZE_NUMBER_INT),
                    'avatar' => $_POST['avatar']
                );

                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = $errors;
                $data['edit_profile'] = true;
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UserController/edit_profile", json_encode($data));
            }

            $this->view("UserView", $data);
        }
    }

    function edit_password($userKey = null)
    {

        if (!isset($userKey)) {
            isLogged();
        }

        $data = array(
            'user_key' => $userKey
        );

        $data['change_password'] = true;

        $this->view("UserView", $data);
    }

    function register()
    {
        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            // 'avatar' => filter_var($_POST['avatar'], FILTER_VALIDATE_URL)
            $params = array(
                'name' => $_POST['name'],
                'nickname' => $_POST['nickname'],
                'email' => $_POST['email'],
                'pass' => $_POST['pass'],
                'confirm-pass' => $_POST['confirm-pass'],
                'avatar' => ""
            );

            $errors = $this->model->checkErrors($params);

            if (count($errors) === 0) {

                // 'avatar' => $_POST['avatar']
                $params = array(
                    'name' => $_POST['name'],
                    'surname' => $_POST['surname'],
                    'nickname' => $_POST['nickname'],
                    'email' => $_POST['email'],
                    'pass' => $_POST['pass'],
                    'avatar' => ""
                );

                $data = $this->model->registry($params);
            } else {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = $errors;
                $data['registry'] = true;
                $data['name'] = $_POST['name'];
                $data['nickname'] = $_POST['nickname'];
                $data['email'] = $_POST['email'];
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UserController/register", json_encode($data));
            }

            $this->view("UserView", $data);
        }
    }

    function change_password()
    {

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $data = array();

            $params = array(
                'pass' => $_POST['pass'],
                'confirm-pass' => $_POST['confirm-pass']
            );

            if (!isset($params['user_key'])) {
                isLogged();
            }

            $errors = array();

            $this->model->checkPass($params, $errors);

            // Si no hay errores, muestro el mensaje
            if (count($errors) === 0) {

                $session = new Session();

                if (isset($_POST['user_key'])) {
                    $params = array(
                        'pass' => $_POST['pass'],
                        'user_key' => $_POST['user_key']
                    );
                } else {
                    $params = array(
                        'id_user' => $session->getAttribute(SESSION_ID_USER),
                        'pass' => $_POST['pass']
                    );
                }

                $data = $this->model->change_password($params);
            } else {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = $errors;
                $data['change_password'] = true;
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "UserController/change_password", json_encode($data));
            }

            $this->view("UserView", $data);
        }
    }

    function logout()
    {
        $session = new Session();
        $session->destroySession();
        redirect_to_url(BASE_URL_ROUTE);
    }

    function display_unsubscribe()
    {
        $data = array();
        $data['display_unsubscribe'] = true;
        $this->view("UserView", $data);
    }

    function unsubscribe()
    {

        isLogged();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->unsubscribe($params);

        if (isModeDebug()) {
            writeLog(INFO_LOG, "UserController/unsubscribe", json_encode($data));
        }

        if ($data['success']) {
            $session->destroySession();
            redirect_to_url(BASE_URL_ROUTE);
        }
    }

    function verification($key)
    {

        $params = [
            'key' => $key
        ];

        $data = $this->model->verification($params);

        $this->view("UserView", $data);
    }

    public function display_verification()
    {
        $data = array();
        $data['form_verification'] = true;
        $this->view("UserView", $data);
    }

    public function resend_confirmation()
    {

        if (isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {

            $params = array(
                'email' => $_POST['email']
            );

            $data = $this->model->resend_confirmation($params);

            $this->view("UserView", $data);
        }
    }

    function no_unsubscribe()
    {
        header("Location: /base-mvc-php/profile");
    }

    function display_topics_user()
    {

        isLogged();

        $session = new Session();

        $params = array(
            'id_user' => $session->getAttribute(SESSION_ID_USER)
        );

        $data = $this->model->search_topics_user($params);

        $data['display_topics_user'] = true;

        $this->view("UserView", $data);
    }
}
