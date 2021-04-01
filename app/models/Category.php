<?php

class Category
{

    function __construct()
    {
    }

    function get_categories($params)
    {

        $db = new PDODB();
        $data = array();
        $data['category'] = array();
        $paramsDB = array();

        try {

            $sql = "SELECT * ";
            $sql .= "FROM categories ";
            if (isset($params['id_cat_parent'])) {
                $sql .= "WHERE id = ? or parent_cat = ? ";

                $paramsDB = array(
                    $params['id_cat_parent'],
                    $params['id_cat_parent']
                );
            }
            $sql .= "ORDER BY name";


            if (isModeDebug()) {
                writeLog(INFO_LOG, "Category/get_categories", $sql);
                writeLog(INFO_LOG, "Category/get_categories", json_encode($paramsDB));
            }

            $datadb = $db->getDataPrepared($sql, $paramsDB);

            if (isset($params['id_cat_parent'])) {
                foreach ($datadb  as $key => $value) {
                    if ($value['id'] == $params['id_cat_parent']) {
                        $data['category'] = $value;
                    }
                }

                $sql = "SELECT DISTINCT c.id, c.name ";
                $sql .= "FROM categories_child cch, categories c ";
                $sql .= "WHERE c.id = cch.id_cat_parent ";
                $sql .= "AND cch.id_cat = ? ";
                $sql .= "ORDER BY level";

                $paramsDB = array(
                    $params['id_cat_parent']
                );

                if (isModeDebug()) {
                    writeLog(INFO_LOG, "Category/get_categories", $sql);
                    writeLog(INFO_LOG, "Category/get_categories", json_encode($paramsDB));
                }

                $parents = $db->getDataPrepared($sql, $paramsDB);

                $numRows = $db->numRowsPrepared($sql, $paramsDB);

                if ($numRows > 0) {

                    $data['breadcumbs'] = array();

                    foreach ($parents as $key => $value) {
                        $breadcumb = new BreadCumb(
                            $value['name'],
                            BASE_URL_ROUTE . 'categoria/' . $value['id'] . '-' . stringToPath($value['name']),
                            null,
                            $key < ($numRows - 1)
                        );

                        array_push($data['breadcumbs'], $breadcumb);
                    }
                }
            } else {
                foreach ($datadb  as $key => $value) {
                    if ($value['id'] === $value['parent_cat']) {
                        $data['category'] = $value;
                    }
                }
            }

            $id_cat_parent_child = $data['category']['id'];

            $child = array_filter($datadb, function ($element) use ($id_cat_parent_child) {
                return $element['parent_cat'] === $id_cat_parent_child
                    && $element['id'] != $element['parent_cat'];
            });

            foreach ($child as $key => $value) {
                $child[$key]['path'] = $value['id'] . '-' . stringToPath($value['name']);
            }

            $data['category']['child'] = $child;
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Category/get_categories", $e->getMessage());
        }

        $db->close();

        return $data;
    }
}
