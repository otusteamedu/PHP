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
            $config->get('connections.mysql.username'),
            $config->get('connections.mysql.password')
        );
    }

    private function getDsn(ConfigContract $config): string
    {
        return 'mysql:host='.$config->get('connections.mysql.host').';port='.$config->get('connections.mysql.port').
               ';dbname='.$config->get('connections.mysql.database');
    }
}
