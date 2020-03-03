<?php


namespace HW\validators;


abstract class Validator
{

    /**
     * @return boolean
     */
    abstract public function validate($email);

}