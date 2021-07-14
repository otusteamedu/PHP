<?php

namespace App\EmailValidator;

use App\Response\Response;

abstract class AbstractValidator
{
    private array $emails;

    public function validate()
    {
        $result = [];

        foreach($this->emails as $email) {
            if (!$this->isValidEmail($email,true)){
                $result[] = ["email" => $email, 'status' => 'invalid'];
            } else {
                $result[] = ["email" => $email, 'status' => 'valid'];
            }
        }

        Response::send(Response::OK, "email-ы проверены", $result);
    }

    public function setEmails(array $emails): void
    {
        $this->emails = $emails;
    }

    abstract protected function isValidEmail(string $email, $extended = false);
}