<?php

namespace Otus\HW7;

use Azatnizam\Email\Validator;

class App {
    protected static $instance;

    protected function __construct() {
    }


    protected function __clone() {
    }


    protected function __wakeup() {
    }


    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }


    public function init() {

        if ($_POST['emails']) {
            $emails = htmlspecialchars($_POST['emails']);
            $arEmails = explode(',', $emails);
            $emailValidator = new Validator();

            foreach ($arEmails as $email) {
                if ( $emailValidator->validateAll($email) ) {
                    print($email . " is valid\n");
                } elseif ($emailValidator->validateAll($email) === null) {
                    print($email . " validators is undefined\n");
                } else {
                    print($email . " is invalid\n");
                }
            }

        } else {
            print('Please enter email');
        }

    }

}
