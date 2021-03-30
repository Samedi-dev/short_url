<?php


namespace App\Services;


class Utils
{
    public static function renderTemplate(string $name)
    {
        $basePath = 'resources/views/';
        $expansion = '.html';
        $path = $basePath . $name . $expansion;

        if (file_exists($path)) {
            return file_get_contents($path);
        }

        return null;
    }

    public static function getShortKey(string $url)
    {
        $arr = explode('/', $url);

        if(isset($arr[1]) && ctype_alnum($arr[1]) && strlen($arr[1]) == 9) {
            return $arr[1];
        }

        return null;
    }
}