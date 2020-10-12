<?php

interface EmailValidatorInterface extends \Validator\ValidatorInterface {
    public function setEmails(array $emails) : void;
}