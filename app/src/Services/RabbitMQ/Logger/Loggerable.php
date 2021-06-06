<?php


namespace App\Services\RabbitMQ\Logger;


interface Loggerable
{
    public function getLogger() : MessageLogger;
    public function setLogger(MessageLogger $logger);
}