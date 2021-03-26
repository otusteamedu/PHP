<?php


namespace Otushw\ServerQueue\Jobs;

use Otushw\Logger\AppLogger;
use Otushw\Storage\Order\OrderMapper;
use PDO;
use Otushw\Storage\DBConnection;

abstract class Job
{
    protected bool $completed = false;
    protected PDO $pdo;
    protected OrderMapper $mapper;

    public function __construct()
    {
        $this->pdo = DBConnection::getInstance();
        $this->mapper = new OrderMapper($this->pdo);
    }

    public function do()
    {
        if ($this->work()) {
            $this->setCompleted();
        }
    }

    protected function setCompleted(): void
    {
        AppLogger::addInfo('RabbitMQ:Consumer job - completed');
        $this->completed = true;
    }

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    abstract protected function work(): bool;
}