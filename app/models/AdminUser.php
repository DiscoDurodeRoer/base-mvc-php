<?php

class AdminUser
{

    function __construct()
    {
    }

    function get_all_users($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {
            $sql = "SELECT * ";
            $sql .= "FROM users ";

            $data['num_elems'] = $db->numRowsPrepared($sql, $paramsDB);

            $sql .= "LIMIT ?,?";

            $paramsDB = array(
                ($params['page'] - 1) * NUM_ITEMS_PAG,
                NUM_ITEMS_PAG
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminUser/get_all_users", $sql);
                writeLog(INFO_LOG, "AdminUser/get_all_users", json_encode($paramsDB));
            }

            $data['users'] = $db->getDataPrepared($sql, $paramsDB);

            // Paginacion
            $data["pag"] = $params['page'];
            $data['last_page'] = ceil($data['num_elems'] / NUM_ITEMS_PAG);
            $data['url_base'] = "/base-mvc-php/admin/user";


            $data['success'] = true;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminUser/get_all_users", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function ban_user($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "UPDATE users ";
            $sql .= "SET baneado = 1 ";
            $sql .= "WHERE id = ? ";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminUser/ban_user", $sql);
                writeLog(INFO_LOG, "AdminUser/ban_user", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            if ($data['success']) {
                $data['message'] = "Usuario baneado correctamente";
            } else {
                $data['message'] = "Usuario no baneado correctamente";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminTopic/ban_user", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function no_ban_user($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {
            $sql = "UPDATE users ";
            $sql .= "SET baneado = 0 ";
            $sql .= "WHERE id = ? ";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminUser/no_ban_user", $sql);
                writeLog(INFO_LOG, "AdminUser/no_ban_user", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            if ($data['success']) {
                $data['message'] = "Usuario des baneado correctamente";
            } else {
                $data['message'] = "Usuario no des baneado correctamente";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminTopic/no_ban_user", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function act_user($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "UPDATE users ";
            $sql .= "SET borrado = 1 ";
            $sql .= "WHERE id = ? ";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminUser/act_user", $sql);
                writeLog(INFO_LOG, "AdminUser/act_user", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            if ($data['success']) {
                $data['message'] = "Usuario activado correctamente";
            } else {
                $data['message'] = "Usuario no activado correctamente";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminTopic/act_user", $e->getMessage());
        }


        $db->close();
        return $data;
    }

    function no_act_user($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "UPDATE users ";
            $sql .= "SET borrado = 0 ";
            $sql .= "WHERE id = ? ";

            $paramsDB = array(
                $params['id_user']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminUser/no_act_user", $sql);
                writeLog(INFO_LOG, "AdminUser/no_act_user", json_encode($paramsDB));
            }

            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            if ($data['success']) {
                $data['message'] = "Usuario desactivado correctamente";
            } else {
                $data['message'] = "Usuario no desactivado correctamente";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminTopic/act_user", $e->getMessage());
        }

        $db->close();
        return $data;
    }
}
