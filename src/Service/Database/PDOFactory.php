<?php


namespace Service\Database;
use PDO;


class PDOFactory
{
    public function getPostgresPDO(): PDO
    {
        return new PDO('pgsql:host=localhost;port=5432;dbname=channeldb;user=defuser;password=defpass');
    }
}