<?php


namespace www\src;


abstract class EmailValidator {
    public abstract function validate($email);
}