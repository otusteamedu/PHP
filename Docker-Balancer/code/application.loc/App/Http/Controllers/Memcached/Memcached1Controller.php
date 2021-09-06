<?php

namespace App\Http\Controllers\Memcached;


use App\Http\Response\IResponse;
use App\Models\Memcached\BaseMemcachedModel;
use App\Models\Memcached\Memcached1Model;


class Memcached1Controller extends BaseMemcachedController
{
    const SERVER_NAME = 'memcached-1';

    /**
     * @var Memcached1Model
     */
    protected BaseMemcachedModel $model;

    /**
     * @param IResponse $response
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new Memcached1Model();
        $this->data['title'] = self::SERVER_NAME;
        $this->data['page_class'] = 'checker is-preload';
    }
}