<?php

namespace Otus;

/**
 * Class EmailChecker
 * @package Otus
 */
class EmailChecker
{

    /**
     * @param string $email
     * @return bool
     * функция валидаци
     *  - проверяет на лайтовую регулярку (только @ и .)
     *  - проверяет домен адреса на наличие MX записи. getmxrr()
     * Вернем false, если в строке нет "@" или ".", или если нет MX-записи для домена адреса
     */
    public function checkEmail(string $email): bool
    {
        if (!preg_match("/.+@.+\..+/i", $email)) {
            return false;
        }

        $domain = substr($email, strpos($email, '@') + 1);

        if (!getmxrr($domain, $mxhosts)) {
            return false;
        }

        return true;
    }

}