<?php

namespace Controllers;

use Symfony\Component\Dotenv\Dotenv;
use Drivers\RabbitmqDriver;

class AppController {
    private $rabbit;

    public function __construct()
    {
        $this->rabbit = new RabbitmqDriver($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD'], $_ENV['RABBITMQ_QUEUE']);

        (new Dotenv())->load('./.env');

        include_once(__DIR__ . '/views/index.html');
    }

    public function run()
    {
        $this->pushPost();

        $this->renderForm(); 
    }

    private function pushPost()
    {
        if (isset($_POST)) {
            $this->rabbitmq->insert(json_encode($_POST));
            $this->rabbitmq->disconnect();
        }
    }
}
