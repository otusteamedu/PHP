<?php
require_once '../bootstrap/bootstrap.php';

use \Monolog\Logger;
use Otus\Consumer\RabbitMQConsumers\RabbitMQConsumer;
use Otus\Exceptions\AppException;
use Otus\Logger\AppLogger;
use PhpAmqpLib\Exception\AMQPConnectionClosedException;

try {

    if (empty($argv[1])) {
        AppLogger::addLog(Logger::WARNING, 'argument is empty');
        return;
    }

    $consumer = getConsumer($argv[1]);
    $consumer->start();

} catch (InvalidArgumentException $exception) {
    AppLogger::addLog(Logger::ERROR, $exception->getMessage());
} catch (AMQPConnectionClosedException $exception) {
    AppLogger::addLog(Logger::WARNING, $exception->getMessage());
} catch (\Exception $exception) {
    AppLogger::addLog(Logger::CRITICAL, $exception->getMessage());
}

/**
 * @param $className
 * @return RabbitMQConsumer
 * @throws AppException
 */
function getConsumer(string $className): RabbitMQConsumer
{
    if (!$className or !class_exists($className)) {
        throw new AppException('cannot create Consumer. Class does not exists');
    }

    return new $className();
}
