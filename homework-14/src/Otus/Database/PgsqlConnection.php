<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use PDO;

class PgsqlConnection extends DBConnection
{
    protected function createPdo(ConfigContract $config): PDO
    {
        return new PDO($this->getDsn($config));
    }

    private function getDsn(ConfigContract $config): string
    {
        return 'pgsql:host='.$config->get('connections.pgsql.host').
               ';port='.$config->get('connections.pgsql.port').
               ';dbname='.$config->get('connections.pgsql.database').
               ';user='.$config->get('connections.pgsql.username').
               ';password='.$config->get('connections.pgsql.password');
    }
}
