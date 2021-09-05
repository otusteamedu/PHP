<?php

namespace App\Http\Controllers\Memcached;


use App\Http\Controllers\BaseController;
use App\Http\Response\IResponse;
use App\Models\NoSqlModel;

/**
 * Контроллер маршрута /Memcached/Memcached
 * Обрабатывает AJAX запросы для Redis соединений
 */
class AloneMemcachedController extends BaseController
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
        $this->title = 'Memcached Server';
        $this->responseMsg = "Response: Memcached server";
        $this->xhrSendCheckerResult($this->model->checkMemcached('memcached')->getShortInfo());
    }
}