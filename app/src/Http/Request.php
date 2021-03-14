<?php 

namespace Http;
use Validation\StringValidator;

class Request 
{
    public $validator;

    public function __construct()
    {
        $this->validator = new StringValidator();
    }

    public function getParam($param)
    {
        return $_REQUEST[$param];
    }

    public function isPostRequest()
    {
        return ($_POST) ? true : false;
    }

    public function hasParam($param)
    {
        return (array_key_exists($param, $_REQUEST)) ? true : false;
    }
}