<?php


namespace HW\validators;


class ValidatorSyntax extends Validator
{
    public function validate($email)
    {
        //TODO is need use regexp?
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

}