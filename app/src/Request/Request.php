<?php

namespace Otus\Request;

use Monolog\Logger;
use Otus\Exceptions\AppException;

class Request
{
    private $requestData;

    public function __construct()
    {
        $json = file_get_contents('php://input');
        $this->requestData = json_decode($json,true);
    }

    public function getData()
    {
        return $this->requestData;
    }

    public function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
}