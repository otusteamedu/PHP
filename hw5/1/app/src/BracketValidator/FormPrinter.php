<?php


namespace BracketValidator;


class FormPrinter
{
    public static function print(string $paramName, $action = '/')
    {
        $allowedSymbols = BracketValidator::ALLOWED_SYMBOLS;

        echo <<<HTML
<p>Допустимые символы "{$allowedSymbols}"<p>
<form action="{$action}" method="POST">
    <input type="text" name="{$paramName}">
    <input type="submit" value="Отправить">
</form>
HTML;
    }
}