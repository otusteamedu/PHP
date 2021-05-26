<?php


use App\Service\Messenger\ChannelBuilderInterface;
use App\Service\Messenger\ExchangeChannelBuilderInterface;
use App\Service\Messenger\RabbitChannelBuilder;
use App\Service\Messenger\RabbitExchangeChannelBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;



return [

    EntityManager::class => function (ContainerInterface $container): EntityManager {

        $config = Setup::createAnnotationMetadataConfiguration(
            $container->get('doctrine')['metadata_dirs'],
            $container->get('doctrine')['isDevMode']
        );

        $driverImpl = new AnnotationDriver(new AnnotationReader, $container->get('doctrine')['metadata_dirs']);
        $config->setMetadataDriverImpl($driverImpl);

        return EntityManager::create($container->get('doctrine')['connection'], $config);
    },

    AMQPStreamConnection::class => function (ContainerInterface $container): AMQPStreamConnection {
        list ($host, $port, $user, $password) = array_values($container->get('rabbit'));

        return new AMQPStreamConnection($host, $port, $user, $password);
    },

    ExchangeChannelBuilderInterface::class => function (ContainerInterface $container): ExchangeChannelBuilderInterface {
        return new RabbitExchangeChannelBuilder($container->get(AMQPStreamConnection::class));
    },

    ChannelBuilderInterface::class => function (ContainerInterface $container): ChannelBuilderInterface {
        return new RabbitChannelBuilder($container->get(AMQPStreamConnection::class));
    },

];
