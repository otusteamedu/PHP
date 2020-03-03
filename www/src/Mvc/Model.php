<?php
namespace Tirei01\Hw12\Mvc;
abstract class Model
{
    public $string;
    private array $params;
    public function __construct($params = array())
    {
        $this->params = $params;
    }
    public function getParam(string $code){
        return $this->params[$code];
    }

    public function redirect($redirect){
        header($redirect, true);
    }
}