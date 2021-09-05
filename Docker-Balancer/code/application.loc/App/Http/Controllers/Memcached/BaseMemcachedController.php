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
        if (!$this->isModelConnected($this->model)) {
            $this->response->send($this->model->getErrorConnectInfo()['code'], $this->model->getErrorConnectInfo()['message'], ['server' => $this->parameters['server']]);
            return;
        }
        $result = ['method' => 'Put'];
        $displayErrors = ini_get('display_errors');
        ini_set("display_errors", '0'); // нужно выключить вывод ошибок на экран, иначе эта ошибка попадет в CheckerResponse

        if (empty($this->parameters['putKey'])) {
            $result += [
                'status' => 'Mistake',
                'server' => $this->parameters['server'],
                'mistake' => ['message' => 'Пустой ключ'],
            ];
        }
        else {
            $result += [
                'status'                => 'OK',
                'server'                => static::SERVER_NAME,
                'lastInsertKey'         => $this->parameters['putKey'],
                'key'                   => $this->parameters['putKey'],
                'lastInsertValue'       => $this->parameters['putValue'],
                'putStatus'             => $this->model->putValue($this->parameters['putKey'], $this->parameters['putValue']),
            ];
        }
        ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
        $this->response->send(StatusCodes::OK, "Response: Memcached->Put", $result);
    }

    /**
     * Возвращает значение по ключу (используются Post-параметры)
     */
    public function xhrGet(): void
    {
        $this->parameters = $this->getParameters();
        if (!$this->isModelConnected($this->model)) {
            $this->response->send($this->model->getErrorConnectInfo()['code'], $this->model->getErrorConnectInfo()['message'], ['server' => $this->parameters['server']]);
            return;
        }
        $result = ['method' => 'Get'];
        $displayErrors = ini_get('display_errors');
        ini_set("display_errors", '0'); // нужно выключить вывод ошибок на экран, иначе эта ошибка попадет в CheckerResponse
        $result += [
            'status' => 'OK',
            'server' => static::SERVER_NAME,
            'key' => $this->parameters['getKey'],
            'value' => $this->model->getValue($this->parameters['getKey']),
        ];
        ini_set("display_errors", $displayErrors); // возвращаем вывод ошибок в исходное состояние
        $this->response->send(StatusCodes::OK, "Response: Memcached->Get", $result);
    }

    /**
     * @param BaseMemcachedModel $model
     * @return bool
     */
    private function isModelConnected(BaseMemcachedModel $model): bool
    {
        return !is_null($model->getConnect());
    }
}