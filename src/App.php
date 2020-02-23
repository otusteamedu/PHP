<?php

namespace App;

use Dotenv\Dotenv;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run as ErrorHandler;

final class App
{
    public function __construct()
    {
        self::loadDotEnv();
        self::setErrorHandler();
    }

    private static function loadDotEnv(): void
    {
        Dotenv::createImmutable(__DIR__ . '/..')->load();
    }

    private static function setErrorHandler(): void
    {
        if (getenv('APP_ENV') === 'dev') {
            (new ErrorHandler())
                ->pushHandler(new PrettyPageHandler())
                ->register();
        }
    }

    public function run(): void
    {
        $responce = 'Ok';
        try {
            self::handleRequest();
        } catch (AppException $e) {
            http_response_code($e->getCode());
            $responce = $e->getMessage();
        }
        echo $responce;
    }


    /**
     * @throws AppException
     */
    private static function handleRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new AppException('Invalid method', 405);
        }
        if (!isset($_POST['string'])) {
            throw new AppException('Invalid arguments', 400);
        }
        if (!self::isStringValid($_POST['string'])) {
            throw new AppException('Invalid string', 400);
        }
    }

    /**
     * @param mixed $string
     * @return bool
     */
    private static function isStringValid($string): bool
    {
        /* $pattern = '/^(\((?>(?1))*\))+$/'; // на случай если валидной считается строка в которой только скобки */
        $pattern = '/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)*+$/';
        return is_string($string)
            && '' !== $string
            && false !== filter_var($string, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $pattern]]);
    }
}
