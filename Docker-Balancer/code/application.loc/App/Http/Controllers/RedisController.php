<?php

namespace App\Http\Controllers;


use App\Exceptions\Checkers\InvalidCheckerException;
use App\Http\Response\IResponse;
use App\Models\NoSqlModel;

/**
 * Контроллер маршрута /Redis
 * Обрабатывает AJAX запросы для Redis соединений
 */
class RedisController extends BaseController
{
    /**
     * Модель
     * @var NoSqlModel
     */
    private NoSqlModel $model;


    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new NoSqlModel();
    }

    /**
     * Проверяет сервер Redis
     */
    public function xhrCheckConnection() {
        $this->title = 'Redis Server';
        $this->responseMsg = "Response: Redis server";
        $this->xhrSendCheckerResult($this->model->checkRedis()->getShortInfo());
    }
}