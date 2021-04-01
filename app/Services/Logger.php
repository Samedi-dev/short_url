<?php


namespace App\Services;


class Logger
{
    public static function setLog(string $error)
    {
        $log = date('Y-m-d H:i:s') . ' - ' . $error . PHP_EOL;
        file_put_contents('logs/errors.log', $log,FILE_APPEND);
    }

    public static function setInfoLog(string $info)
    {
        $log = date('Y-m-d H:i:s') . ' - ' . $info . PHP_EOL;
        file_put_contents('logs/info.log', $log,FILE_APPEND);
    }
}