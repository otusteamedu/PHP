<?php


namespace App\Services\Database;


interface DB
{
    public function getPdo() : \PDO;
}