<?php

namespace App\Http\Controllers;


use App\Http\Response\IResponse;
use App\Models\NoSqlModel;

/**
 * Контроллер маршрута /Elasticsearch
 * Обрабатывает AJAX запрос для Elasticsearch соединения
 */
class ElasticsearchController extends BaseController
{
    /**
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
     * Проверяет сервер Elasticsearch
     */
    public function xhrCheckConnection(): void
    {
        $this->title = 'Elasticsearch Server';
        $this->responseMsg = "Response: Elasticsearch server";
        $this->xhrSendCheckerResult($this->model->checkElasticsearch()->getInfo());
    }
}