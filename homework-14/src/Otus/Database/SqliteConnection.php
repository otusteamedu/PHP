<?php

namespace Otus\Database;

use Otus\Config\ConfigContract;
use PDO;

class SqliteConnection extends DBConnection
{
    protected function createPdo(ConfigContract $config): PDO
    {
        return new PDO($this->getDsn($config));
    }

    private function getDsn(ConfigContract $config): string
    {
        return 'sqlite:dbname='.$config->get('db_database');
    }
}
