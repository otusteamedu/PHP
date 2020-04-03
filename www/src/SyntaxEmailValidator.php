<?php


namespace www\src;


class SyntaxEmailValidator extends EmailValidator {


    public function __construct() {
    }

    public function validate($email) : bool {
        return (preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $email));
    }
}