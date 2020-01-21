<?php

namespace App;

/**
 * Class Config
 * @package App
 */
class Config
{
    public const DB_TYPE = 'pgsql';
    public const DB_HOST = 'otus-postgres';
    public const DB_PORT = 5432;
    public const DB_NAME = 'cinema';
    public const DB_USER = 'cinema';
    public const DB_PASS = '1231';

    public const RABBIT_HOST = 'otus-rabbitmq';
    public const RABBIT_PORT = 5672;
    public const RABBIT_USER = 'admin';
    public const RABBIT_PASS = '1231';
    public const RABBIT_QUEUE = 'manager';
}
