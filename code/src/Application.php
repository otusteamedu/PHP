<?php
namespace code\src;
use code\src\Exceptions\Hw5ParamException;

class Application {
    private  $validator;
    private  $parameter;

    public function __construct() {
        $this->parameter = $_POST['string'];
        $this->validator = new Validator($this->parameter);
    }

    public function run () : string {
        if (!isset($this->parameter) || empty($this->parameter)) {
            $e = new Hw5ParamException();
            return $e->__toString();
        }

        if ($this->validator->validate()) {$message = 'Everything is GOOD => correct bracket sequence'. PHP_EOL;}
        else  {$message = 'Everything is BAD => incorrect bracket sequence'. PHP_EOL;}
        return $message;
    }
}