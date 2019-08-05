<?php

use Psr\Container\ContainerInterface;

return [
    'database.connection' => 'mysql:host='.getenv('MYSQL_HOST').';port='.getenv('MYSQL_PORT').';dbname='.getenv('MYSQL_DB'),
    'database.user' => getenv('MYSQL_USER'),
    'database.password' => getenv('MYSQL_PASSWORD'),
    'rabbit.host' => getenv('RABBIT_HOST'),
    'rabbit.port' => getenv('RABBIT_PORT'),
    'rabbit.user' => getenv('RABBIT_USER'),
    'rabbit.pass' => getenv('RABBIT_PASSWORD'),
    \crazydope\theater\database\adapter\PdoAdapterInterface::class => static function(ContainerInterface $c) {
        return new \crazydope\theater\database\adapter\PdoAdapter(
            $c->get('database.connection'),$c->get('database.user'),$c->get('database.password')
        );
    },
    \crazydope\theater\Model\Message::class => new \crazydope\theater\Model\Message(),
    \crazydope\theater\database\ResultSet::class => \DI\create()->constructor(DI\get(\crazydope\theater\Model\Message::class)),
    \crazydope\theater\database\TableGatewayInterface::class => static function(ContainerInterface $c) {
        return new \crazydope\theater\database\TableGateway('messages',
            $c->get(\crazydope\theater\database\adapter\PdoAdapterInterface::class),
            $c->get(\crazydope\theater\database\ResultSet::class)
        );
    },
    \crazydope\theater\Model\MessageTableInterface::class => static function(ContainerInterface $c) {
        return new \crazydope\theater\Model\MessageTable($c->get(\crazydope\theater\database\TableGatewayInterface::class));
    },
    \PhpAmqpLib\Connection\AMQPStreamConnection::class => \DI\create()->constructor(
        DI\get('rabbit.host'),
        DI\get('rabbit.port'),
        DI\get('rabbit.user'),
        DI\get('rabbit.pass')
    ),
    \crazydope\theater\Job\Adapter\AdapterInterface::class => static function(ContainerInterface $c) {
        return new \crazydope\theater\Job\Adapter\RabbitMqAdapter($c->get(\PhpAmqpLib\Connection\AMQPStreamConnection::class));
    },
    \crazydope\theater\Job\QueueInterface::class => static function(ContainerInterface $c) {
      return new \crazydope\theater\Job\Queue($c->get(\crazydope\theater\Job\Adapter\AdapterInterface::class));
    },
    \crazydope\theater\Controller\ApiController::class => \DI\create()->lazy()->constructor(
        DI\get(\crazydope\theater\Model\MessageTableInterface::class),
        DI\get(\crazydope\theater\Job\QueueInterface::class)
    ),
];