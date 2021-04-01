<?php


namespace App\Models;


use App\Services\ConnectionDB;
use App\Services\Logger;
use Exception;

class ShortLink extends ConnectionDB
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOriginalUrl($key): string
    {
        $query = "SELECT * FROM links WHERE short = '" . $key . "'";

        try {
            $result = $this->connect()->query($query);
            while ($row = $result->fetch()) {
                return $row['url'];
            }
        } catch (Exception $exception) {
            Logger::setLog($exception->getMessage());
        }

        return '';
    }

    public function getShortUrl($key)
    {
        $query = "SELECT * FROM links WHERE url = '" . $key . "'";

        try {
            $result = $this->connect()->query($query);

            while ($row = $result->fetch()) {
                return $row['short'];
            }
        } catch (Exception $exception) {
            Logger::setLog($exception->getMessage());
        }

        return '';
    }

    public function getCountRecordUrl($key)
    {
        $query = "SELECT count(*) FROM links WHERE url = '" . $key . "'";

        try {
            $result = $this->connect()->query($query);

            while ($row = $result->fetch()) {
                if ($row['count'] == 1) {
                    return true;
                }
            }
        } catch (Exception $exception) {
            Logger::setLog($exception->getMessage());
        }

        return false;
    }

    public function setShortUrl(string $url): void
    {
        $short = $this->generateShortUrl();
        $query = "INSERT INTO links (url, short) VALUES ('". $url . "','" . $short ."')";

        try {
            $this->connect()->query($query);
        } catch (Exception $exception) {
            Logger::setLog($exception->getMessage());
        }
    }

    private function generateShortUrl($length = 9): string
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            try {
                $bytes = random_bytes($size);
            } catch (Exception $e) {
                $e->getMessage();
            }

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return mb_strtolower($string, 'UTF-8');
    }
}