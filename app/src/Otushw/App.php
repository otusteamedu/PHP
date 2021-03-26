<?php

namespace Otushw;

use GuzzleHttp\Psr7\ServerRequest;
use Otushw\Storage\DBConnection;
use Otushw\Storage\OrderMapper;
use PDO;

class App
{

    private AppInstanceAbstract $appInstance;
    private PDO $pdo;
    private OrderMapper $orderMapper;

    public function __construct()
    {
        $this->loadConfig();
        $app = new AppFactory();
        $this->appInstance = $app->create();
//        $this->pdo = DBConnection::getInstance();
//        $this->orderMapper = new OrderMapper($this->pdo);
    }

    private function loadConfig(): void
    {
        Config::create();
    }

    public function run()
    {
        $this->appInstance->run();
    }
}

