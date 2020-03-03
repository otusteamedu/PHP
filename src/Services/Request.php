<?php

namespace App\Services;

use App\Exceptions\BadRequestException;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\UnprocessableEntityException;

class Request
{
    private const FIELD_STRING = 'string';

    /** @var self */
    private static $instance;

    private function __construct()
    {
    }

    /**
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @throws \App\Exceptions\BadRequestException
     * @throws \App\Exceptions\MethodNotAllowedException
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    public function process()
    {
        if (!$this->isPost()) {
            throw new MethodNotAllowedException('Запрос можно отправить только методом POST.');
        }

        $string = $this->getData(self::FIELD_STRING);
        if (empty($string)) {
            throw new UnprocessableEntityException('В поле ' . self::FIELD_STRING . ' нет данных.');
        }

        if (!Brackets::test($string)) {
            throw new BadRequestException('Передана некорректная строка.');
        }

        http_response_code(200);
        echo "Строка в порядке!";
    }

    /**
     * @return bool
     */
    private function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * @param string $field
     * @return mixed
     * @throws \App\Exceptions\UnprocessableEntityException
     */
    private function getData(string $field)
    {
        if (isset($_POST[$field])) {
            return $_POST[$field];
        }

        throw new UnprocessableEntityException("В запросе не указано поле {$field}.");
    }
}
