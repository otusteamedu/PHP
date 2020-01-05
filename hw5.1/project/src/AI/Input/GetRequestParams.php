<?php


namespace AI\backend_php_hw5_1\Input;


class GetRequestParams extends Input
{
    public function __construct()
    {
        $this->params = $_GET;
    }
}