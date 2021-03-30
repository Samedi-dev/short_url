<?php


namespace App\Services;


class Logger
{
    public static function setLog($error)
    {
        $log = date('Y-m-d H:i:s') . ' - ' . $error;
        file_put_contents('errors.log', $log,FILE_APPEND);
    }
}