<?php


namespace App;


use App\Console\Command;
use Dotenv\Dotenv;
use Dotenv\Repository\Adapter\EnvConstAdapter;
use Dotenv\Repository\Adapter\PutenvAdapter;
use Dotenv\Repository\RepositoryBuilder;

class App
{

    private $responceCode = 200;
    private $responce = null;

    /**
     * @return string
     * @throws Console\Exceptions\CommandNotFound
     */
    public function run()
    {
        $this->loadEnv();
        Command::exec();
        return $this->responce;
    }

    private function loadEnv()
    {
        $repository = RepositoryBuilder::createWithNoAdapters()
            ->addAdapter(EnvConstAdapter::class)
            ->addWriter(PutenvAdapter::class)
            ->allowList([
                'DB_DRIVER',
                'DB_HOST',
                'DB_NAME',
                'DB_USER',
                'DB_PORT',
                'DB_PASSWORD',
            ])->immutable()->make();
        Dotenv::create($repository, __DIR__ . '/../docker')->load();
    }
}