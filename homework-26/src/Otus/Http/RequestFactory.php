<?php

namespace Otus\Http;

use Otus\Http\Parsers\FormDataParser;
use Otus\Http\Parsers\JsonParser;

class RequestFactory
{
    private Request $request;

    private function __construct()
    {
        if ($this->isForm()) {
            $parser        = new FormDataParser();
            $this->request = new Request($parser->parse());

            return;
        }

        if ($this->isJson()) {
            $parser        = new JsonParser();
            $this->request = new Request($parser->parse());

            return;
        }

        $this->request = new Request($_GET);
    }

    public static function make(): Request
    {
        $instance = new self();

        return $instance->getRequest();
    }

    public function isForm(): bool
    {
        if (! array_key_exists('CONTENT_TYPE', $_SERVER)) {
            return false;
        }

        if ($_SERVER['CONTENT_TYPE'] !== 'application/x-www-form-urlencoded') {
            return false;
        }

        return true;
    }

    public function isJson(): bool
    {
        if (! array_key_exists('CONTENT_TYPE', $_SERVER)) {
            return false;
        }

        if (mb_strpos($_SERVER['CONTENT_TYPE'], 'json') === false) {
            return false;
        }

        return true;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
