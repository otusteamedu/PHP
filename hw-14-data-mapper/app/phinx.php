<?php

use App\Config\Config;
use App\Log\Log;
use App\Storage\Storage;
use Monolog\Logger;

try {
    $config = Config::getInstance();
    $config->setConfig('config.yml');
    $dbconfig = $config->getItem(Storage::DB_CONFIG_KEY);

    return
        [
            'paths'         => [
                'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
                'seeds'      => '%%PHINX_CONFIG_DIR%%/db/seeds',
            ],
            'environments'  => [
                'default_migration_table' => 'phinxlog',
                'default_environment'     => 'development',
                'production'              => [
                    'adapter' => 'mysql',
                    'host'    => 'localhost',
                    'name'    => 'production_db',
                    'user'    => 'root',
                    'pass'    => '',
                    'port'    => '3306',
                    'charset' => 'utf8',
                ],
                'development'             => [
                    'adapter' => 'mysql',
                    'host'    => $dbconfig['host'] ?? 'localhost',
                    'name'    => $dbconfig['dbname'] ?? 'development_db',
                    'user'    => $dbconfig['user'] ?? 'root',
                    'pass'    => $dbconfig['password'] ?? '',
                    'port'    => $dbconfig['port'] ?? '3306',
                    'charset' => 'utf8',
                ],
                'testing'                 => [
                    'adapter' => 'mysql',
                    'host'    => 'localhost',
                    'name'    => 'testing_db',
                    'user'    => 'root',
                    'pass'    => '',
                    'port'    => '3306',
                    'charset' => 'utf8',
                ],
            ],
            'version_order' => 'creation',
        ];

} catch (Exception $e) {
    Log::getInstance()->addRecord($e->getMessage(), Logger::ERROR);
}

