<?php

class AdminCategory
{

    function __construct()
    {
    }

    function get_categories($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {

            $sql = "SELECT cc.id, cc.name, cc.description, cp.name as parent, cc.icon, ";
            $sql .= "(select count(*) from categories WHERE cc.id = parent_cat) as has_child ";
            $sql .= "FROM categories cc, categories cp ";
            $sql .= "WHERE cc.parent_cat = cp.id ";

            if ($params['mode'] == ONLY_PARENTS) {
                
            } else if ($params['mode'] == ONLY_CHILDS) {
                $sql .= "and (select count(*) from categories WHERE cc.id = parent_cat) = 0 ";
            } else {
                $data['num_elems'] = $db->numRowsPrepared($sql, $paramsDB);
                $sql .= "LIMIT ?,?";
                $paramsDB = array(
                    ($params['page'] - 1) * NUM_ITEMS_PAG,
                    NUM_ITEMS_PAG
                );
            }

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminCategory/get_categories", $sql);
                writeLog(INFO_LOG, "AdminCategory/get_categories", json_encode($paramsDB));
            }

            $data['categories'] = $db->getDataPrepared($sql, $paramsDB);

            if ($params['mode'] === ALL_CATEGORIES) {
                $data["pag"] = $params['page'];
                $data['last_page'] = ceil($data['num_elems'] / NUM_ITEMS_PAG);
                $data['url_base'] = "/base-mvc-php/admin/categorias";
            }

            $data['success'] = true;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminCategory/get_categories", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function create_category($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $data['message'] = array();
        $paramsDB = array();

        try {

            if (empty($params['name'])) {

                if (empty($params['name'])) {
                    array_push($data['message'], "El nombre de la categoria es obligatoria");
                }
            } else {

                $id_cat_new = $db->getLastId("id", "categories");

                $sql = "INSERT INTO categories VALUES(?,?,?,?,'',0)";

                $paramsDB = array(
                    $id_cat_new,
                    $params['name'],
                    $params['description'],
                    $params['parent_cat']
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "AdminCategory/create_category", $sql);
                    writeLog(INFO_LOG, "AdminCategory/create_category", json_encode($paramsDB));
                }

                $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

                $sql = "SELECT id_cat_parent, level ";
                $sql .= "FROM categories_child ";
                $sql .= "WHERE id_cat = ? ";
                $sql .= "ORDER BY level ";

                $paramsDB = array(
                    $params['parent_cat']
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "AdminCategory/create_category", $sql);
                    writeLog(INFO_LOG, "AdminCategory/create_category", json_encode($paramsDB));
                }

                $categories_child = $db->getDataPrepared($sql, $paramsDB);

                $last_level = 0;

                foreach ($categories_child as $key => $value) {

                    $sql = "INSERT INTO categories_child VALUES(?,?,?)";

                    $paramsDB = array(
                        $id_cat_new,
                        $value['id_cat_parent'],
                        $value['level']
                    );

                    $last_level = $value['level'];

                    if (isModeDebug()) {
                        writeLog(INFO_LOG, "AdminCategory/create_category", $sql);
                        writeLog(INFO_LOG, "AdminCategory/create_category", json_encode($paramsDB));
                    }

                    $db->executeInstructionPrepared($sql, $paramsDB);
                }

                $sql = "INSERT INTO categories_child VALUES(?,?,?)";

                $paramsDB = array(
                    $id_cat_new,
                    $id_cat_new,
                    ($last_level + 1)
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "AdminCategory/create_category", $sql);
                    writeLog(INFO_LOG, "AdminCategory/create_category", json_encode($paramsDB));
                }

                $db->executeInstructionPrepared($sql, $paramsDB);

                if ($data['success']) {
                    $data['message'] = "La categoria se ha creado correctamente";
                } else {
                    $data['message'] = "La categoria no se ha creado correctamente";
                }
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminCategory/create_category", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function get_category($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {

            $sql = "SELECT cc.id, cc.name, cc.description, cc.parent_cat, ";
            $sql .= "cp.name as parent, cc.icon, ";
            $sql .= "(select count(*) from categories WHERE cc.id = parent_cat) as has_child ";
            $sql .= "FROM categories cc, categories cp ";
            $sql .= "WHERE cc.parent_cat = cp.id and";
            $sql .= " cc.id = ? ";

            $paramsDB = array(
                $params['id_category']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminCategory/get_category", $sql);
                writeLog(INFO_LOG, "AdminCategory/get_category", json_encode($paramsDB));
            }

            $data['category'] = $db->getDataSinglePrepared($sql, $paramsDB);
            $data['success'] = true;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminCategory/get_category", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function edit_category($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $data['message'] = array();
        $paramsDB = array();

        try {

            if (empty($params['name']) || empty($params['description'])) {

                if (empty($params['name'])) {
                    array_push($data['message'], "El nombre de la categoria es obligatoria");
                }
            } else {
                $sql = "UPDATE categories SET ";
                if (isset($params['parent_cat'])) {
                    $sql .= "parent_cat = ?, ";
                }
                $sql .= "name = ?, ";
                $sql .= "description = ? ";
                $sql .= "WHERE id = ? ";

                if (isset($params['parent_cat'])) {
                    $paramsDB = array(
                        $params['parent_cat'],
                        $params['name'],
                        $params['description'],
                        $params['id']
                    );
                } else {
                    $paramsDB = array(
                        $params['name'],
                        $params['description'],
                        $params['id']
                    );
                }

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "AdminCategory/edit_category", $sql);
                    writeLog(INFO_LOG, "AdminCategory/edit_category", json_encode($paramsDB));
                }

                $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

                if (isset($params['parent_cat']) && $params['parent_cat'] != $params['parent_cat_ori']) {

                    $sql  = "SELECT distinct level ";
                    $sql .= "FROM categories_child ";
                    $sql .= "WHERE id_cat_parent = (";
                    $sql .=     "SELECT parent_cat ";
                    $sql .=     "FROM categories ";
                    $sql .=     "WHERE id = ?) ";
                    $sql .= "ORDER BY level ";

                    $paramsDB = array(
                        $params['parent_cat']
                    );

                    $level_delete = $db->getDataPrepared($sql, $paramsDB);
                    $level_delete = array_column($level_delete, "level");

                    if (isModeDebug()) {
                        writeLog(INFO_LOG, "AdminCategory/edit_category", $sql);
                        writeLog(INFO_LOG, "AdminCategory/edit_category", json_encode($paramsDB));
                    }

                    $sql = "DELETE FROM categories_child ";
                    $sql .= "WHERE id_cat = ? ";
                    $sql .= "and level >= (?)";

                    $paramsDB = array(
                        $params['id'],
                        implode(",", $level_delete)
                    );

                    if (isModeDebug()) {
                        writeLog(INFO_LOG, "AdminCategory/edit_category", $sql);
                        writeLog(INFO_LOG, "AdminCategory/edit_category", json_encode($paramsDB));
                    }

                    $db->executeInstruction($sql);

                    $sql = "SELECT id_cat_parent, level ";
                    $sql .= "FROM categories_child ";
                    $sql .= "WHERE id_cat = ? ";
                    $sql .= "and id_cat_parent not in (SELECT id_cat_parent ";
                    $sql .=                           "FROM categories_child ";
                    $sql .=                           "WHERE id_cat = ?) ";
                    $sql .= "ORDER BY level ";

                    $paramsDB = array(
                        $params['parent_cat'],
                        $params['id']
                    );

                    if (isModeDebug()) {
                        writeLog(INFO_LOG, "AdminCategory/edit_category", $sql);
                        writeLog(INFO_LOG, "AdminCategory/edit_category", json_encode($paramsDB));
                    }

                    $parents = $db->getDataPrepared($sql, $paramsDB);

                    $last_level = end($level_delete);

                    foreach ($parents as $key => $value) {

                        $sql = "INSERT INTO categories_child VALUES(?,?,?)";

                        $paramsDB = array(
                            $params['id'],
                            $value['id_cat_parent'],
                            $value['level']
                        );

                        $last_level = $value['level'];

                        if (isModeDebug()) {
                            writeLog(INFO_LOG, "AdminCategory/create_category", $sql);
                            writeLog(INFO_LOG, "AdminCategory/create_category", json_encode($paramsDB));
                        }

                        $db->executeInstructionPrepared($sql, $paramsDB);
                    }

                    $sql = "INSERT INTO categories_child VALUES(?,?,?)";

                    $paramsDB = array(
                        $params['id'],
                        $params['id'],
                        ($last_level + 1)
                    );

                    if (isModeDebug()) {
                        writeLog(INFO_LOG, "AdminCategory/create_category", $sql);
                        writeLog(INFO_LOG, "AdminCategory/create_category", json_encode($paramsDB));
                    }

                    $db->executeInstructionPrepared($sql, $paramsDB);
                }

                if ($data['success']) {
                    array_push($data['message'], "Se ha editado la categoria correctamente");
                } else {
                    array_push($data['message'], "No se ha editado la categoria correctamente");
                }
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminCategory/edit_category", $e->getMessage());
        }

        $db->close();
        return $data;
    }

    function delete_category($params)
    {

        $db = new PDODB();
        $data = array();
        $data['show_message_info'] = true;
        $paramsDB = array();

        try {

            $sql = "DELETE FROM categories_child ";
            $sql .= "WHERE id_cat = ? ";

            $paramsDB = array(
                $params['id_category']
            );

            $db->executeInstructionPrepared($sql, $paramsDB);

            $sql = "DELETE FROM categories ";
            $sql .= "WHERE id = ? ";

            $paramsDB = array(
                $params['id_category']
            );

            if (isModeDebug()) {
                writeLog(INFO_LOG, "AdminCategory/delete_category", $sql);
                writeLog(INFO_LOG, "AdminCategory/delete_category", json_encode($paramsDB));
            }
            
            $data['success'] = $db->executeInstructionPrepared($sql, $paramsDB);

            if ($data['success']) {
                $data['message'] = "Se ha borrado la categoria correctamente";
            } else {
                $data['message'] = "No se ha borrado la categoria correctamente";
            }
        } catch (Exception $e) {
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "AdminCategory/delete_category", $e->getMessage());
        }

        $db->close();
        return $data;
    }
}
