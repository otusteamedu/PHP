<?php

namespace App\Http\Controllers;


use App\Exceptions\Checkers\InvalidCheckerException;
use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Response\IResponse;
use App\Models\SqlModel;

/**
 * Контроллер маршрута /Sql
 */
class SqlController extends BaseController
{
    /**
     * Модель
     * @var SqlModel
     */
    private SqlModel $model;


    /**
     * @param IResponse $response
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new SqlModel();
        $this->data['title'] = 'Sql checkers';
        $this->data['page_class'] = 'checker is-preload';
    }

    /**
     * Обработчик маршрута по умолчанию
     *
     * @throws ViewLoaderException
     */
    public function run() {
        $this->data += $this->getParameters();
        $this->loadView('Templates/header');
        $this->loadView('Sql/header_sql');
        $this->loadView('Sql/sql_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Обработчик маршрута Sql/check
     *
     * @throws ViewLoaderException|InvalidCheckerException
     */
    public function check(): void
    {
        $this->data += $this->getParameters();
        $allInfo = match($this->getItemNameToCheck()) {
            'mysql-masteron'    => [['title' => 'Mysql Server PDO', 'info' => $this->model->checkMysqlPdo('mysql-master')->getInfo()]],
            'mysql-slaveon'     => [['title' => 'Mysql Server PDO', 'info' => $this->model->checkMysqlPdo('mysql-slave')->getInfo()]],
            'mysql-master'      => [['title' => 'Mysqli Server', 'info' => $this->model->checkMysqli('mysql-master')->getInfo()]],
            'mysql-slave'       => [['title' => 'Mysqli Server', 'info' => $this->model->checkMysqli('mysql-slave')->getInfo()]],
            'postgreson'        => [['title' => 'Postgres Server PDO', 'info' => $this->model->checkPostgresPdo('postgres')->getInfo()]],
            'postgres'          => [['title' => 'Postgres Server PgConnect', 'info' => $this->model->checkPostgresPgConnect('postgres')->getInfo()]],
            default             => $this->getAllSqlConnectInfo()
        };
        $this->show($allInfo);
    }

    private function getAllSqlConnectInfo(): array
    {
        return [
            'mysql-masteron'    => ['title' => 'Mysql Server PDO', 'info' => $this->model->checkMysqlPdo('mysql-master')->getInfo()],
            'mysql-slaveon'     => ['title' => 'Mysql Server PDO', 'info' => $this->model->checkMysqlPdo('mysql-slave')->getInfo()],
            'mysql-master'      => ['title' => 'Mysqli Server', 'info' => $this->model->checkMysqli('mysql-master')->getInfo()],
            'mysql-slave'       => ['title' => 'Mysqli Server', 'info' => $this->model->checkMysqli('mysql-slave')->getInfo()],
            'postgreson'        => ['title' => 'Postgres Server PDO', 'info' => $this->model->checkPostgresPdo('postgres')->getInfo()],
            'postgres'          => ['title' => 'Postgres Server PgConnect', 'info' => $this->model->checkPostgresPgConnect('postgres')->getInfo()],
        ];
    }

    /**
     * Отображает контент
     *
     * @param array $info
     * @throws ViewLoaderException
     */
    private function show(array $info): void
    {
        $this->loadView('Templates/header');
        $this->loadView('Sql/header_sql');
        foreach ($info as $sqlServer) {
            $this->data['sql'] = $sqlServer;
            $this->loadView('');
        }
        $this->loadView('Sql/sql_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Возвращает имя Checker-а на основе get-параметров.
     *
     * @return string
     */
    private function getItemNameToCheck(): string
    {
        return ($this->data['db'] ?? '') . ($this->data['pdo'] ?? '');
    }
}