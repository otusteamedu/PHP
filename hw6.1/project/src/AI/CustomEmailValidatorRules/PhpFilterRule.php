<?php

namespace AI\backend_php_hw6_1\CustomEmailValidatorRules;


use AI\EmailValidator\Rules\Rule;

/**
 * Class PhpFilterRule
 *
 * Реализует кастомное правило для пакета AI\EmailValidator.
 * Проверяет переданный email средствами из стандартной бибилиотеки PHP.
 * @url https://www.php.net/manual/ru/function.filter-var
 *
 * "Под капотом" отрабатывает регулярное выражение.
 * @url https://github.com/php/php-src/blob/master/ext/filter/logical_filters.c#L615
 *
 * @package AI\backend_php_hw6_1\CustomEmailValidatorRules
 */
class PhpFilterRule extends Rule
{
    public function check(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
