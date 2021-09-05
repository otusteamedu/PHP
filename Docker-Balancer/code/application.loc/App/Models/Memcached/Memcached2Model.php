<?php

namespace App\Models\Memcached;

use App\Exceptions\Connection\InvalidArgumentException;

class Memcached2Model extends BaseMemcachedModel
{
    const MODEL_NAME = 'memcached-2';

    /**
     * Конструктор класса
     *
     * @throws InvalidArgumentException
     */
/*    public function __construct()
    {
        $this->connect(self::MODEL_NAME);
        $this->checkerName = self::MODEL_NAME;
        $this->title = self::MODEL_NAME;
    }*/
}