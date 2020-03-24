<?php

namespace code\src\Exceptions;

class Hw5ParamException extends \Exception {
    public function __toString() : string {
       return $mess = "Something wrong with string param";
    }

}