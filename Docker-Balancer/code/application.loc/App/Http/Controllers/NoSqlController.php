<?php

namespace App\Http\Controllers;


use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Response\IResponse;
use App\Models\NoSqlModel;
use JetBrains\PhpStorm\ArrayShape;

/**
 * Контроллер маршрута /NoSql
 */
class NoSqlController extends BaseController
{
    /**
     * Модель
     * @var NoSqlModel
     */
    private NoSqlModel $model;


    /**
     * @param IResponse $response
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new NoSqlModel();
        $this->data['title'] = 'NoSql checkers';
        $this->data['page_class'] = 'checker is-preload';
    }

    /**
     * Обработчик маршрута по умолчанию
     *
     * @throws ViewLoaderException
     */
    public function run(): void
    {
        $this->data += $this->getParameters();
        $this->loadView('Templates/header');
        $this->loadView('NoSql/header_nosql');
        $this->loadView('NoSql/nosql_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Обработчик маршрута NoSql/check
     *
     * @throws ViewLoaderException
     */
    public function check(): void
    {
        $this->data += $this->getParameters();
        if ($this->getItemNameToCheck() === 'memcachedCluster') {
            $this->memcachedCluster();
        } else {
            $info = match($this->getItemNameToCheck()) {
                'redis'             => [['title' => 'Redis Server', 'info' => $this->model->checkRedis()->getInfo()]],
                'elasticsearch'     => [['title' => 'Elasticsearch Server', 'info' => $this->model->checkElasticsearch()->getInfo()]],
                'memcached'         => [['title' => 'Memcached Server', 'info' => $this->model->checkMemcached('memcached')->getInfo()]],
                default             => $this->getAllNoSqlConnectInfo()
            };
            $this->show($info);
        }
    }

    /**
     * Обработчик маршрута NoSql/memcachedCluster
     *
     * @throws ViewLoaderException
     */
    public function memcachedCluster(): void
    {
        $this->data['memcached1'] = $this->model->checkMemcached('memcached-1')->getShortInfo();
        $this->data['memcached2'] = $this->model->checkMemcached('memcached-2')->getShortInfo();

        $this->data += $this->getParameters();
        $this->loadView('Templates/header');
        $this->loadView('Memcached/cluster');
        $this->loadView('Templates/footer');
    }

    /**
     * @return array[]
     */

    #[ArrayShape(['redis' => "array", 'elasticsearch' => "array", 'memcached' => "array"])]
    private function getAllNoSqlConnectInfo(): array
    {
        return [
            'redis'             => ['title' => 'Redis Server', 'info' => $this->model->checkRedis()->getInfo()],
            'elasticsearch'     => ['title' => 'Elasticsearch Server', 'info' => $this->model->checkElasticsearch()->getInfo()],
            'memcached'         => ['title' => 'Memcached Server', 'info' => $this->model->checkMemcached('memcached')->getInfo()],
        ];
    }

    /**
     * Отображает контент
     *
     * @param array $allInfo
     * @throws ViewLoaderException
     */
    private function show(array $allInfo): void
    {
        $this->loadView('Templates/header');
        $this->loadView('NoSql/header_nosql');
        foreach ($allInfo as $info) {
            $this->data['nosql'] = $info;
            $this->loadView('');
        }
        $this->loadView('NoSql/nosql_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Возвращает имя Checker-а на основе get-параметров.
     *
     * @return string
     */
    private function getItemNameToCheck(): string
    {
        return ($this->data['db'] ?? '');
    }
}