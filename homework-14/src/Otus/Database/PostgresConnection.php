<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use PDO;

class PostgresConnection extends DBConnection
{
    protected function createPdo(ConfigContract $config): PDO
    {
        return new PDO($this->getDsn($config));
    }

    private function getDsn(ConfigContract $config): string
    {
        return 'pgsql:host='.$config->get('db_host').';port='.$config->get('db_port').
               ';dbname='.$config->get('db_database').';user='.$config->get('db_username').
               ';password='.$config->get('password');
    }
}
