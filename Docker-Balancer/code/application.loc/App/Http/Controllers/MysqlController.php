<?php

namespace App\Http\Controllers;


use App\Http\Response\Checker\CheckerResponse;
use App\Http\Response\IResponse;
use App\Models\SqlModel;
use Src\Database\Connectors\MySqlPdoSqlConnector;
use Exception;

/**
 * Контроллер маршрута /Mysql
 * Обрабатывает AJAX запросы для MySql соединений
 */
class MysqlController extends BaseController
{
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
     * Проверяет сервер Mysql с помощью 'PDO'
     */
    public function xhrCheckPdoConnection(): void
    {
        $this->title = 'MySql Server PDO';
        $this->responseMsg = "Response: MySql server PDO";
        $this->xhrSendCheckerResult(
            match (mb_strtolower($this->getParameters()['data'])) {
                'slave' => $this->model->checkMysqlPdo('mysql-slave')->getInfo(),
                default => $this->model->checkMysqlPdo('mysql-master')->getInfo(),
            }
        );
    }

    /**
     *  Проверяет сервер MySql с помощью драйвера 'mysqli'
     */
    public function xhrCheckMysqliConnection(): void
    {
        $this->title = 'MySql Server. Driver: `Mysqli`';
        $this->responseMsg = "Response: MySql server (Mysqli)";
        $this->xhrSendCheckerResult(
            match (mb_strtolower($this->getParameters()['data'])) {
                'slave' => $this->model->checkMysqli('mysql-slave')->getInfo(),
                default => $this->model->checkMysqli('mysql-master')->getInfo(),
            }
        );
    }
}