<?php


namespace App\Services\Database\PostgreSQL;


use App\Services\Database\DB;

class PostgresSqlDB implements DB
{
    public function getPdo(): \PDO
    {
        return Client::get();
    }
}