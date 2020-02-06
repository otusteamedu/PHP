<?php

namespace App;

use BadMethodCallException;
use InvalidArgumentException;
use Throwable;

use function http_response_code;

/**
 * Class App
 * @package App
 */
class App
{
    public function run(): void
    {
        try {
            $method = $_SERVER['REQUEST_METHOD'] ?? null;
            $string = $_POST['string'] ?? null;

            if ($method !== 'POST') {
                throw new BadMethodCallException('Доступен только POST запрос');
            }

            if ($string === null) {
                throw new InvalidArgumentException('Параметр "string" обязателен');
            }

            if ($string === '') {
                throw new InvalidArgumentException('Параметр "string" не может быть пустым');
            }

            $parenthesesValidator = new ParenthesesValidator();
            $isValidString        = $parenthesesValidator->validate($string);

            if ($isValidString) {
                echo 'Данные успешно прошли валидацию';

                return;
            }

            throw new InvalidArgumentException('Данные не прошли валидацию');
        } catch (Throwable $exception) {
            http_response_code(400);
            echo $exception->getMessage();
        }
    }
}
