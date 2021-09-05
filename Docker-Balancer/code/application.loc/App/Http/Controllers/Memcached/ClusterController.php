<?php

namespace App\Http\Controllers\Memcached;


use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Controllers\BaseController;
use App\Http\Response\IResponse;
use App\Models\Memcached\Memcached1Model;
use App\Models\Memcached\Memcached2Model;
use App\Models\NoSqlModel;


class ClusterController extends BaseController
{
    /**
     * Общая Модель для NoSql серверов
     * @var NoSqlModel
     */
    private NoSqlModel $model;

    /**
     * параметры из запроса
     * @var array
     */
    protected array $parameters;

    /**
     * Модель для сервера Memcached-1
     * @var Memcached1Model
     */
    private Memcached1Model $memcached1Model;

    /**
     * Модель для сервера Memcached-2
     * @var Memcached2Model
     */
    private Memcached2Model $memcached2Model;


    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = New NoSqlModel();
        $this->memcached1Model = new Memcached1Model();
        $this->memcached2Model = new Memcached2Model();
        $this->data['title'] = 'Memcached ClusterController';
        $this->data['page_class'] = 'checker is-preload';
    }

    /**
     * Обработчик маршрута Memcached/cluster
     *
     * @throws ViewLoaderException
     */
    public function run(): void
    {
        $this->data['memcached1'] = $this->model->checkMemcached('memcached-1')->getShortInfo();
        $this->data['memcached2'] = $this->model->checkMemcached('memcached-2')->getShortInfo();

        $this->data += $this->getParameters();
        $this->loadView('Templates/header');
        $this->loadView('Memcached/cluster');
        $this->loadView('Templates/footer');
    }
}