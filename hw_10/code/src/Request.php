<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */

namespace APP;

class Request
{
    public static function getData(): array
    {
        return $_REQUEST;
    }

    public static function isRequestValid(): bool
    {
        return self::isContentLengthEqual();
    }

    private static function isContentLengthEqual(): bool
    {
        $requestBodyLength = strlen(file_get_contents('php://input'));
        $requestBodyLengthFromHeader = (int)$_SERVER['CONTENT_LENGTH'];
        return $requestBodyLength === $requestBodyLengthFromHeader;
    }
}