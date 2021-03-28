<?php


namespace Otus\Request;


use Otus\Exception\AppException;

class Requst
{
    public function __construct()
    {
        $json = file_get_contents('php://input');

        if (empty($json)) {
            throw new AppException('body is empty', Logger::ERROR);
        }

        $this->data = json_decode($json,true);
    }
}