<?php


namespace App\Routes;


use App\Controllers\UrlController;
use App\Http\Request;

class BaseRoute extends Request
{
    private UrlController $urlController;

    public function __construct()
    {
        parent::__construct();
        $this->urlController = new UrlController();
    }

    public function dispatch()
    {
        if ($this->getRequestUri() == '/ajax' && $this->isPost()) {
            $this->urlController->ajax($this->getRequestUrl(), $this->getHost());
            exit();
        }

        if (strlen($this->getRequestUri()) <= 9 && strlen($this->getRequestUri()) != 1) {
            $this->urlController->getPage('error-invalid-link');
        }

        if (strlen($this->getRequestUri()) == 10)   {
            $this->urlController->checkShortUrl($this->getRequestUri());
        }

        if ($this->getRequestUri() == '/') {
            $this->urlController->getPage('create-short-link');
        }
    }

    public static function redirectTo(string $originUrl)
    {
        header('Location: '. $originUrl, false, 302);
    }
}