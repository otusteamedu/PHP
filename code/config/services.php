<?php


use App\Service\AirlineService\AirlineService;
use App\Service\AirlineService\AirlineServiceInterface;
use App\Service\AirlineService\AirlineValidator;
use App\Service\Mailer\MailerInterface;
use App\Service\Mailer\MailerService;
use App\Service\Message\MessageService;
use App\Service\Message\MessageServiceInterface;
use App\Service\Security\SecurityInterface;
use App\Service\Security\SecurityService;
use App\Utils\Builder\AMQPChannelBuilderInterface;
use App\Utils\Builder\AMQPChannelBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;


return [
    EntityManager::class => function (ContainerInterface $container): EntityManager {

        $loader = require __DIR__ . '/../vendor/autoload.php';
        \Doctrine\Common\Annotations\AnnotationRegistry::registerLoader([$loader, 'loadClass']);

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

    AMQPChannelBuilderInterface::class => function (ContainerInterface $container): AMQPChannelBuilderInterface {
        return new AMQPChannelBuilder($container->get(AMQPStreamConnection::class));
    },

    SecurityInterface::class => function (EntityManagerInterface $entityManager): SecurityInterface {
        return new SecurityService($entityManager);
    },

    MessageServiceInterface::class => function (AMQPChannelBuilderInterface $channelBuilder): MessageServiceInterface {
        return new MessageService($channelBuilder);
    },

    LoggerInterface::class => function (ContainerInterface $container): LoggerInterface {
        list ($name, $path) = array_values($container->get('logger'));
        $level = $container->get('development') ? Logger::DEBUG : Logger::WARNING;

        $logger = new Logger($name);
        $logger->pushHandler(new StreamHandler($path, $level));

        return $logger;
    },

    MailerInterface::class => function (ContainerInterface $container): MailerInterface {
        list ($host, $port, $username, $password) = array_values($container->get('smtp'));

        $transport = (new Swift_SmtpTransport($host, $port))
            ->setUsername($username)
            ->setPassword($password);

        $mailer = new Swift_Mailer($transport);

        return new MailerService($mailer);
    },

    PhpRenderer::class => function (ContainerInterface $container): PhpRenderer {
        return new PhpRenderer($container->get('templates_path'));
    },

    AirlineServiceInterface::class => function (EntityManagerInterface $entityManager, LoggerInterface $logger): AirlineServiceInterface {
        $validator = new AirlineValidator();
        return new AirlineService($entityManager, $logger, $validator);
    },

];
