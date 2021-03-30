<?php


namespace App\Http;


class Request
{
    private array $server;
    private array $request;

    protected function __construct()
    {
        $this->server = $_SERVER;
        $this->request = $_REQUEST;
    }

    protected function getRequestUri(): string
    {
        if ($this->server['REQUEST_URI']) {
            return $this->server['REQUEST_URI'];
        }

        return null;
    }

    protected function getHost(): string
    {
        if ($this->server['HTTP_HOST']) {
            return $this->server['HTTP_HOST'];
        }

        return null;
    }

    protected function getRequestUrl(): string
    {
        if ($this->request['url']) {
            return $this->request['url'];
        }

        return null;
    }

    protected function isPost(): bool
    {
        if ($this->server['REQUEST_METHOD'] == 'POST') {
            return true;
        }

        return false;
    }
}