<?php


namespace App;


class Request
{

    private array $params = [];

    private string $url = '';

    public function __construct()
    {
        if (!empty($_REQUEST)) {
            $this->params = $_REQUEST;
        }

        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $this->url = $url[0];
    }

    public function get(string $param_name, $default = '') {
        return ($this->params[$param_name] ?: $default);
    }

    public function getUrl()
    {
        return $this->url;
    }
}