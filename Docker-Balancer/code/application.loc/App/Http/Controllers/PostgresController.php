<?php

namespace App\Http\Controllers;


use App\Http\Response\IResponse;
use App\Models\SqlModel;
use App\Services\Checkers\Inspector;
use Exception;
use App\Services\Checkers\Sql\Postgres\PostgresPdoChecker;
use App\Services\Checkers\Sql\Postgres\PostgresPgConnectChecker;

/**
 * Контроллер маршрута /Postgres
 * Обрабатывает AJAX запросы для Postgres соединений
 */
class PostgresController extends BaseController
{
    const DEFAULT_SERVER_NAME = 'postgres';

    /**
     * Модель
     * @var SqlModel
     */
    private SqlModel $model;


    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new SqlModel();
    }

    /**
     * Проверяет сервер Postgres с помощью 'PDO'
     */
    public function xhrCheckPdoConnection() {
        $this->title = 'Postgres Server PDO';
        $this->responseMsg = "Response: Postgres server PDO";
        $serverName = $this->getParameters()['data'] ?? self::DEFAULT_SERVER_NAME;
        $this->xhrSendCheckerResult(
            match (mb_strtolower($serverName)) {
                default => $this->model->checkPostgresPdo('postgres')->getInfo(),
            }
        );
    }

    /**
     * * Проверяет сервер Postgres с помощью драйвера 'PgConnect'
     */
    public function xhrCheckPgConnection() {
        $this->title = 'Postgres Server. Driver: `PgConnect`';
        $this->responseMsg = "Response: Postgres server (PgConnect)";
        $serverName = $this->getParameters()['data'] ?? self::DEFAULT_SERVER_NAME;
        $this->xhrSendCheckerResult(
            match (mb_strtolower($serverName)) {
                default => $this->model->checkPostgresPgConnect('postgres')->getInfo(),
            }
        );
    }
}