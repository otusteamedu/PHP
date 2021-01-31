<?php

namespace App3;

use App3\Exception\EmailException;

/**
 * Class Main
 * @package App
 */
class Main
{
    private array $emails = [
        'o@gmail.com',
        'okolesnikov90@gmail.com',
        'o@asdasd.com',
        'o123@a2sdasd.com',
        'ok@gmail.com',
        '@gmail.com',
        'test@mail.com',
        'test@.com',
        'test@',
        'test',
    ];

    /**
     * Main constructor.
     */
    public function __construct()
    {
    }

    /**
     * @throws EmailException
     */
    public function run()
    {
        foreach ($this->emails as $email) {
            echo $email . $this->validate($email);
        }
    }

    /**
     * @param string $email
     * @return string
     */
    private function validate(string $email): string
    {
        $exp = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";
        $emailArray = explode('@', $email) ?? [];
        $hostName = array_pop($emailArray);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match($exp, $email)) {
            return " : Не прошел валидацию <br/>";
        }

        if (!checkdnsrr($hostName, "MX")) {
            return " : Нет записей MX <br/>";
        }

        return " : Коректный email <br/>";
    }
}