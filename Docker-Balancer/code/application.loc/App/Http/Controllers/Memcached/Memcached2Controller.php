<?php

namespace App\Http\Controllers\Memcached;


use App\Http\Response\IResponse;
use App\Models\Memcached\BaseMemcachedModel;
use App\Models\Memcached\Memcached2Model;


class Memcached2Controller extends BaseMemcachedController
{
    const SERVER_NAME = 'memcached-2';

    /**
     * @var Memcached2Model
     */
    protected BaseMemcachedModel $model;

    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new Memcached2Model();
        $this->data['title'] = self::SERVER_NAME;
        $this->data['page_class'] = 'checker is-preload';
    }
}