<?php

namespace App;

use RuntimeException;

final class Task
{
    /* '/^(\((?>(?1))*\))+$/'; // на случай если валидной считается строка в которой только скобки */
    private const PATTERN = '/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)*+$/';

    /**
     * @return string
     */
    public static function run(): string
    {
        $responce = 'Ok';
        try {
            self::handleRequest();
        } catch (RuntimeException $e) {
            http_response_code($e->getCode());
            $responce = $e->getMessage();
        }
        return $responce;
    }

    /**
     * @throws RuntimeException
     */
    private static function handleRequest(): void
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new RuntimeException('Invalid SAPI', 400);
        }
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new RuntimeException('Invalid method', 405);
        }
        if (!isset($_POST['string'])) {
            throw new RuntimeException('Invalid arguments', 400);
        }
        if (!self::isStringValid($_POST['string'])) {
            throw new RuntimeException('Invalid string', 400);
        }
    }

    /**
     * @param mixed $string
     * @return bool
     */
    private static function isStringValid($string): bool
    {
        return is_string($string)
            && '' !== $string
            && false !== filter_var($string, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => self::PATTERN]]);
    }
}
