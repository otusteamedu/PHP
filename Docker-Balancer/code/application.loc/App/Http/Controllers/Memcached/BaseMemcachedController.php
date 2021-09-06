<?php

namespace App\Http\Controllers\Memcached;


use App\Http\Controllers\BaseController;
use App\Http\Response\Checker\ErrorResponse;
use App\Http\Response\Helpers\StatusCodes;
use App\Http\Response\MemcachedResponse;
use App\Models\Memcached\BaseMemcachedModel;


abstract class BaseMemcachedController extends BaseController
{
    const SERVER_NAME = 'memcached';

    /**
     * параметры из запроса
     * @var array
     */
    protected array $parameters;

    /**
     * Модель
     * @var BaseMemcachedModel
     */
    protected BaseMemcachedModel $model;


    /**
     * Сохраняет значение по ключу (используются Post-параметры)
     */
    public function xhrPut(): void
    {
        $this->parameters = $this->getParameters();
        $result = $this->model->putValueReply($this->parameters['putKey'], $this->parameters['putValue']);
        $this->response->send($result['code'], $result['message'], $result['info']);
    }

    /**
     * Возвращает значение по ключу (используются Post-параметры)
     */
    public function xhrGet(): void
    {
        $this->parameters = $this->getParameters();
        $result = $this->model->getValueReply($this->parameters['getKey']);
        $this->response->send($result['code'], $result['message'], $result['info']);
    }
}