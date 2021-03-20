<?php 

namespace Http;
use Validation\StringValidator;

class Request 
{
    public $validator;
    public $post;

    public function __construct()
    {
        $this->validator = new StringValidator();
        $this->post = ($this->isPostRequest()) ? $_POST : null;
    }

    public function getParam($param)
    {
        return $this->post[$param];
    }

    public function isPostRequest()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;
    }

    public function hasParam($param)
    {
        return (array_key_exists($param, $this->post)) ? true : false;
    }
}