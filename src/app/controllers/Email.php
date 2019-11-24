<?php

namespace Controllers;

use Core\AppController;
use Core\AppException;
use Utils\ValidatorRules;
use Utils\Validators\EmailValidator;
use Utils\Validators\EmailValidatorException;

class Email extends AppController
{
    /**
     * @throws AppException
     */
    public function validateAddr()
    {
        $errors = [];
        $rules = new ValidatorRules($this->appConfig->validation);

        $emailsAddresses = array_filter(array_map(function ($str) {
            return trim($str);
        }, explode(",", $_POST["emails"] ?? "")), function ($addr) {
            return !empty($addr);
        });

        if (empty($emailsAddresses)) throw new AppException("Nothing to check");

        foreach ($emailsAddresses as $emailsAddress) {
            $validator = new EmailValidator($emailsAddress, $rules->emailPattern);
            try {
                $validator->validateAddress();

                if ($rules->emailMxCheck) {
                    try {
                        $validator->validateMX();
                    } catch (EmailValidatorException $e) {
                        $errors[] = "{$e->getMessage()} > incorrect domain";
                    }
                }

            } catch (EmailValidatorException $e) {
                $errors[] = "{$e->getMessage()} > incorrect address";
            }
        }

        if (!empty($errors)) {
            throw new AppException(implode("; ", $errors));
        } else {
            $this->response->content = "OK";
        }
    }
}