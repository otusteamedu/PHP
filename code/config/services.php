<?php



use App\Service\Airline\AirlineService;
use App\Service\Airline\AirlineServiceInterface;
use App\Service\Airline\AirlineValidator;
use App\Service\City\CityService;
use App\Service\City\CityServiceInterface;
use App\Service\FlightSchedule\FlightScheduleService;
use App\Service\FlightSchedule\FlightScheduleServiceInterface;
use App\Service\Message\MessageHandlers\RequestMessageHandler;
use App\Service\Message\MessageService;
use App\Service\Message\MessageServiceInterface;
use App\Service\Middleware\AuthMiddleware;
use App\Service\Request\RequestService;
use App\Service\Request\RequestServiceInterface;
use App\Service\Security\SecurityInterface;
use App\Service\Security\SecurityService;
use App\Utils\Builder\AMQPChannelBuilderInterface;
use App\Utils\Builder\AMQPChannelBuilder;
use App\Utils\Validator\StringValidator;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
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
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);

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

    PhpRenderer::class => function (ContainerInterface $container): PhpRenderer {
        return new PhpRenderer($container->get('templates_path'));
    },

    AirlineServiceInterface::class => function (EntityManagerInterface $entityManager): AirlineServiceInterface {
        $stringValidator = new StringValidator();
        $validator = new AirlineValidator($stringValidator);
        return new AirlineService($entityManager, $validator);
    },

    AuthMiddleware::class => function (SecurityInterface $security): AuthMiddleware {
        return new AuthMiddleware($security);
    },

    CityServiceInterface::class => function (EntityManagerInterface $entityManager): CityServiceInterface {
        $stringValidator = new StringValidator();
        return new CityService($entityManager, $stringValidator);
    },

    FlightScheduleServiceInterface::class => function (EntityManagerInterface $entityManager): FlightScheduleServiceInterface {
        return new FlightScheduleService($entityManager);
    },

    RequestServiceInterface::class => function (EntityManagerInterface $entityManager, MessageServiceInterface $messageService): RequestServiceInterface {
        return new RequestService($entityManager, $messageService);
    },

    RequestMessageHandler::class => function (ContainerInterface $container, EntityManagerInterface $entityManager): RequestMessageHandler {
        return new RequestMessageHandler($container, $entityManager);
    },

];
