<?php

namespace Controllers;

use \Drivers\MongodbDriver;
use \Drivers\RabbitmqDriver;

class ApiController {
    private $mongodb;
    private $rabbitmq;

    public function __construct()
    {
        $this->mongodb = new MongodbDriver($_ENV['MONGODB_DSN'], $_ENV['MONGODB_DATABASE'], $_ENV['MONGODB_COLLECTION']);
        $this->rabbitmq = new RabbitmqDriver($_ENV['RABBITMQ_HOST'], $_ENV['RABBITMQ_PORT'], $_ENV['RABBITMQ_USER'], $_ENV['RABBITMQ_PASSWORD'], $_ENV['RABBITMQ_QUEUE']);
    }

    public function get(string $id) : array
    {
        return $this->mongodb->getById($id);
    }   

    public function insert() 
    {
        $id = $this->mongodb->insert(['status' => false]);
        $this->rabbitmq->insert($id);
        $this->rabbitmq->disconnect();

        return json_encode($this->mongodb->getById($id));
    }
}
