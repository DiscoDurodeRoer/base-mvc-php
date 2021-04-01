<?php

class Login
{

    function __construct()
    {
    }

    function checkLogin($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {

            if (empty($params['nick_email']) && empty($params['pass'])) {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = "Usuario/email y contraseña requeridos";
            } elseif (empty($params['nick_email'])) {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = "Usuario/email requerido";
            } elseif (empty($params['pass'])) {
                $data['show_message_info'] = true;
                $data['success'] = false;
                $data['message'] = "Contraseña requerida";
            } else {

                $sql = "SELECT id, nickname, rol ";
                $sql .= "FROM users ";
                $sql .= "WHERE (nickname = ? OR email = ?) ";
                $sql .= "AND pass = ? ";
                $sql .= "and borrado <> 1 ";
                $sql .= "and verificado = 1";

                $paramsDB = array(
                    strtolower($params['nick_email']),
                    strtolower($params['nick_email']),
                    hash_hmac("sha512", $params['pass'], HASH_PASS_KEY)
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "Login/checkLogin", $sql);
                    writeLog(INFO_LOG, "Login/checkLogin", json_encode($paramsDB));
                }

                $data = $db->getDataSinglePrepared($sql, $paramsDB);

                if ($db->numRowsPrepared($sql, $paramsDB) > 0) {
                    $data['success'] = true;
                    $data['user'] = array('id' => $data['id'], 'nickname' => $data['nickname'], 'rol' => $data['rol']);
                } else {
                    $data['show_message_info'] = true;
                    $data['success'] = false;
                    $data['message'] = "Usuario/email o contraseña incorrectos";
                }
            }
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Login/checkLogin", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function sendNotificationRememeber($params)
    {
        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "SELECT id, email ";
            $sql .= "FROM users ";
            $sql .= "WHERE email = ? ";

            $paramsDB = array(
                $params['email']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "Login/sendNotificationRememeber", $sql);
                writeLog(INFO_LOG, "Login/sendNotificationRememeber", json_encode($paramsDB));
            }

            if ($db->numRowsPrepared($sql, $paramsDB) > 0) {

                $id = $db->getDataSinglePropPrepared($sql, "id", $paramsDB);

                $key = generateUserKey();

                $sql = "INSERT INTO users_remember VALUES (?,?)";

                $paramsDB = array(
                    $id,
                    $key
                );

                $db->executeInstructionPrepared($sql, $paramsDB);

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "Login/sendNotificationRememeber", $sql);
                    writeLog(INFO_LOG, "Login/sendNotificationRememeber", json_encode($paramsDB));
                }

                $paramsEmail = array(
                    'key' => $key
                );

                sendEmail(
                    $params['email'],
                    "Cambio de contraseña",
                    TEMPLATE_EDIT_PASSWORD,
                    $paramsEmail
                );

                $data['success'] = true;
                $data['message'] = "Se ha enviado un correo para poder cambiar la contraseña";
            } else {
                $data['success'] = false;
                $data['message'] = "El email no existe";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Login/sendNotificationRememeber", $e->getMessage());
        }

        $db->close();

        return $data;
    }
}
