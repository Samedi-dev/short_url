<?php


namespace App\Controllers;


use App\Models\ShortLink;
use App\Routes\BaseRoute;
use App\Services\Logger;
use App\Services\Utils;

class UrlController
{
    private ShortLink $shortLink;

    public function __construct()
    {
        $this->shortLink = new ShortLink();
    }

    public function getPage(string $name): void
    {
        echo Utils::renderTemplate($name);
    }

    public function checkShortUrl(string $url): void
    {
        $shortKey = Utils::getShortKey($url);
        $originalUrl = $this->shortLink->getOriginalUrl($shortKey);
        Logger::setInfoLog('Load record - ' . $originalUrl);

            if ($originalUrl) {
                BaseRoute::redirectTo($originalUrl);
            }

        $this->getPage('error-invalid-link');
    }

    public function ajax(string $url, string $host): void
    {
        if (!$this->shortLink->getCountRecordUrl($url)) {
            Logger::setInfoLog("New unique link");
            $this->shortLink->setShortUrl($url);
            Logger::setInfoLog("Save new short link");
        } else {
            Logger::setInfoLog("The link is already in the database, load the previously saved short link");
        }

        $shortUrl = $this->shortLink->getShortUrl($url);
        $this->sendJsonResponse($host, $shortUrl);
    }

    private function sendJsonResponse(string $host, string $shortUrl)
    {
        Logger::setInfoLog("Short link in json response = " . $shortUrl);
        if (!empty($shortUrl)) {
            echo json_encode(array(
                'link' => $host . '/' . $shortUrl
            ));
        } else {
            echo json_encode(array(
                'link' => 'Oops something went wrong, try again'
            ));
        }
    }
}