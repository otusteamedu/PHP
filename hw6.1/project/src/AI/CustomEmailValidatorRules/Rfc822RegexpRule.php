<?php

namespace AI\backend_php_hw6_1\CustomEmailValidatorRules;


use AI\EmailValidator\Rules\Rule;

/**
 * Class Rfc822RegexpRule
 *
 * Реализует кастомное правило для пакета AI\EmailValidator.
 * Проверяет переданный email на соответствие стандарту RFC 822 регулярным выражением.
 *
 * @url http://www.ex-parrot.com/~pdw/Mail-RFC822-Address.html
 *
 * @package AI\backend_php_hw6_1\CustomEmailValidatorRules
 */
class Rfc822RegexpRule extends Rule
{
    protected function check(string $email): bool
    {
        $re = file_get_contents(__DIR__ . '/Rfc822RegexpRule.txt');
        $re = '/' . str_replace("\n", '', $re) . '/';

        return (bool) preg_match($re, $email);
    }
}
