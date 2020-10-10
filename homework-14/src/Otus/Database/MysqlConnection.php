<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use PDO;

class MysqlConnection extends DBConnection
{
    protected function createPdo(ConfigContract $config): PDO
    {
        return new PDO(
            $this->getDsn($config),
            $config->get('db_username'),
            $config->get('db_password')
        );
    }

    private function getDsn(ConfigContract $config): string
    {
        return 'mysql:host='.$config->get('db_host').';port='.$config->get('db_port').
               ';dbname='.$config->get('db_database');
    }
}
