<?php

namespace App\Config;

use App\Database\PsqlDatabaseConnection;
use App\Database\PsqlQueriesBuilderBuilder;

class Config
{
    /**
     * @throws \Exception
     */
    public function createDbClient(): object
    {
        if (!getenv("DATABASE_STORAGE")) {
            throw new \Exception('Choose database storage');
        }

        switch (getenv("DATABASE_STORAGE")) {
            case 'postgres':
                return PsqlDatabaseConnection::connect();
                break;
        }
    }

    public function createQueriesBuilder(): object
    {
        if (!getenv("DATABASE_STORAGE")) {
            throw new \Exception('Choose database storage');
        }

        switch (getenv("DATABASE_STORAGE")) {
            case 'postgres':
                return new PsqlQueriesBuilderBuilder();
                break;
        }
    }
}