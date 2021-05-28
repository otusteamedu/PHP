<?php


use App\Service\Messenger\ChannelBuilderInterface;
use App\Service\Messenger\RabbitChannelBuilder;
use App\Service\Security\SecurityInterface;
use App\Service\Security\SecurityService;
use App\Service\Session\Session;
use App\Service\Session\SessionInterface;
use App\Service\Storage\SessionStorage;
use App\Service\Storage\SessionStorageInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
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

    EntityManagerInterface::class => function (ContainerInterface $container): EntityManagerInterface {
        return $container->get(EntityManager::class);
    },

    AMQPStreamConnection::class => function (ContainerInterface $container): AMQPStreamConnection {
        list ($host, $port, $user, $password) = array_values($container->get('rabbit'));

        return new AMQPStreamConnection($host, $port, $user, $password);
    },

    ChannelBuilderInterface::class => function (ContainerInterface $container): ChannelBuilderInterface {
        return new RabbitChannelBuilder($container->get(AMQPStreamConnection::class));
    },

    SessionInterface::class => function (ContainerInterface $container): SessionInterface {
        return new Session($container);
    },

    SessionStorageInterface::class => function (SessionInterface $session): SessionStorageInterface {
        return new SessionStorage($session);
    },

    SecurityInterface::class => function (SessionStorageInterface $sessionStorage, EntityManagerInterface $entityManager): SecurityInterface {
        return new SecurityService($sessionStorage, $entityManager);
    }

];
