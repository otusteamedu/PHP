<?php


namespace App;


use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class RabbitMQ
 * @package App
 */
final class RabbitMQ
{
    /**
     * @var
     */
    private static $instance;

    /**
     * RabbitMQ constructor.
     */
    private function __construct()
    {
    }

    /**
     * @return RabbitMQ
     */
    public static function getInstance(): RabbitMQ
    {
        if(!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     *
     */
    private function __clone(){}

    /**
     *
     */
    private function __wakeup(){}


    /**
     * @return AMQPStreamConnection
     */
    public  function init()
    {


        return new  AMQPStreamConnection('rabbitmq', 5672, getenv('RabbitMQ_USER'), getenv('RabbitMQ_PASSWORLD'));
    }


}