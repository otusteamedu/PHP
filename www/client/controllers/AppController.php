<?php

namespace Controllers;

use Symfony\Component\Dotenv\Dotenv;
use Drivers\RabbitmqDriver;

class AppController {
    public $env;
    private $rabbit;

    public function __construct()
    {
        $this->env = include_once('./config/env.php');
        (new Dotenv())->load($this->env['dir']);

        $this->rabbit = new RabbitmqDriver($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD'], $_ENV['RABBITMQ_QUEUE']);
    }

    public function run()
    {
        $this->pushPost();

        $this->renderForm(); 
    }

    public function renderForm()
    {
        include_once(__DIR__ . '/views/index.html');
    }

    private function pushPost()
    {
        if (isset($_POST)) {
            $this->rabbitmq->insert(json_encode($_POST));
            $this->rabbitmq->disconnect();
        }
    }
}
