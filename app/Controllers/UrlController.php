<?php


namespace App\Controllers;


use App\Models\ShortLink;
use App\Routes\BaseRoute;
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

            if ($originalUrl) {
                BaseRoute::redirectTo($originalUrl);
            }

        $this->getPage('error-invalid-link');
    }

    public function ajax(string $url, string $host): void
    {
        if ($this->checkLinkAvailability($url)) {
            $this->shortLink->setShortUrl($url);
        }

        $shortUrl = $this->shortLink->getShortUrl($url);
        $this->sendJsonResponse($host, $shortUrl);
    }

    private function checkLinkAvailability(string $url): bool
    {
        if ($url) {

            if ($this->shortLink->getShortUrl($url)) {
                return false;
            }
        }

        return true;
    }

    private function sendJsonResponse(string $host, string $shortUrl)
    {
        echo json_encode(array(
            'link' => $host . '/' . $shortUrl
        ));
    }
}