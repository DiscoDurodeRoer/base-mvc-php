<?php

class Log
{

    // estructura del log
    // [Tipo_mensaje] [fecha_hora] [origen] [mensaje]

    private $fileLog;

    function __construct()
    {
        $this->fileLog = fopen(PATH_LOG . FILE_LOG, "a");
    }

    function writeLine($type, $origin, $message)
    {
        $date = new DateTime();
        fputs($this->fileLog, "[" . $type . "][" . $date->format('d-m-Y H:i:s') . "][" . $origin . "]: " . $message . "\n");
    }

    function getLines()
    {

        $data = array();

        $reader = fopen(PATH_LOG . FILE_LOG, "r");
        while (!feof($reader)) {
            $text = fgets($reader);
            if (!empty($text)) {

                $start_type = 1;
                $end_type = 1;

                $start_date = 4;
                $end_date = strpos($text, "]", $start_date);

                $start_origin = $end_date + 2;
                $end_origin = strpos($text, "]", $start_origin);

                $start_message = $end_origin + 3;

                $line = array(
                    "type" => substr($text, $start_type, $end_type),
                    "date" => substr($text, $start_date, $end_date - $start_date),
                    "origin" => substr($text, $start_origin, $end_origin - $start_origin)
                );

                $message = trim(substr($text, $start_message));

                if (is_array(json_decode($message, JSON_PRETTY_PRINT))) {
                    $line["message"] = "<pre>".json_encode(json_decode($message, JSON_PRETTY_PRINT), JSON_PRETTY_PRINT)."</pre>";
                } else {
                    $line["message"] = $message;
                }

                array_push($data, $line);
            }
        }

        $data = array_reverse($data);

        fclose($reader);

        return $data;
    }

    function clear()
    {
        ftruncate($this->fileLog, 0);
    }

    function close()
    {
        fclose($this->fileLog);
    }
}
