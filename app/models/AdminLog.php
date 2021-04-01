<?php

class AdminLog
{

    function __construct()
    {
    }

    function get_lines_log()
    {

        $data = array();

        $log = new Log();
        $data["lines"] = $log->getLines();
        $log->close();

        return $data;
    }

    function delete_content_log()
    {

        $data = array();

        $log = new Log();
        $log->clear();
        $data["lines"] = $log->getLines();
        $log->close();

        return $data;
    }
}
