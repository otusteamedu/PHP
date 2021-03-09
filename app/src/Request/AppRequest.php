<?php


namespace Otus\Request;


class AppRequest
{
    private array $data = [];

    public function __construct()
    {
        $json = file_get_contents('php://input');
        $request = json_decode($json, true);

        if (!empty($request)) {
            $this->data = $request;
        }
    }

    public function getData(): array
    {
        return $this->data;
    }
}