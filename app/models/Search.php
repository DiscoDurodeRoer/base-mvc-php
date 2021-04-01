<?php

class Search
{

    function __construct()
    {
    }

    function search_topics($params)
    {

        $db = new PDODB();
        $data = array();
        $paramsDB = array();

        try {
            $wordsSearched = explode('+', $params['searched']);

            $sql = "SELECT * ";
            $sql .= "FROM topics ";
            $sql .= "WHERE ";

            for ($i = 0; $i < count($wordsSearched); $i++) {
                if (!empty($wordsSearched[$i])) {
                    $sql .= " title LIKE ? ";
                    array_push($paramsDB, "%" . urldecode($wordsSearched[$i]) . "%");
                    if ($i !== count($wordsSearched) - 1) {
                        $sql .= " OR ";
                    }
                }
            }
            if (isModeDebug()) {
                writeLog(INFO_LOG, "Search/search_topics", json_encode($wordsSearched));
                writeLog(INFO_LOG, "Search/search_topics", $sql);
                writeLog(INFO_LOG, "Search/search_topics", json_encode($paramsDB));
            }

            $data['topics'] = $db->getDataPrepared($sql, $paramsDB);

            $data['has_results'] = $db->numRowsPrepared($sql, $paramsDB);
        } catch (Exception $e) {
            $data['show_message_info'] = true;
            $data['success'] = false;
            $data['message'] = ERROR_GENERAL;
            writeLog(ERROR_LOG, "Search/search_topics", $e->getMessage());
        }

        $db->close();
        return $data;
    }
}
