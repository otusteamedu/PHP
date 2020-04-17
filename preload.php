<?php

/**
 * @file Предзагрузка
 * Может вызывать излишнее потребление памяти, т.к. грузит все что есть в composer classmap
 */

$files = require __DIR__ . '/vendor/composer/autoload_classmap.php';
$files = array_unique($files);

/** @noinspection ClassConstantCanBeUsedInspection */
unset(
    $files['Psr\\Log\\Test\\DummyTest'],
    $files['Psr\\Log\\Test\\LoggerInterfaceTest'],
    $files['Psr\\Log\\Test\\TestLogger'],
    $files['Symfony\\Contracts\\Service\\Test\\ServiceLocatorTest'],
    $files['Monolog\\Test\\TestCase'],
    $files['Monolog\\Handler\\SwiftMailerHandler'],
    $files['Monolog\\Handler\\SqsHandler'],
    $files['Monolog\\Handler\\RollbarHandler'],
    $files['Monolog\\Handler\\PHPConsoleHandler'],
    $files['Monolog\\Handler\\GelfHandler'],
    $files['Monolog\\Handler\\ElasticsearchHandler'],
    $files['Monolog\\Handler\\ElasticaHandler'],
    $files['Monolog\\Handler\\DynamoDbHandler'],
    $files['Monolog\\Handler\\DoctrineCouchDBHandler'],
    $files['Monolog\\Formatter\\GelfMessageFormatter'],
    $files['JsonException'],
    $files['Symfony\\Component\\Console\\Event\\ConsoleTerminateEvent'],
    $files['Symfony\\Component\\Console\\Event\\ConsoleEvent'],
    $files['Symfony\\Component\\Console\\Event\\ConsoleErrorEvent'],
    $files['Symfony\\Component\\Console\\Event\\ConsoleCommandEvent'],
    $files['Symfony\\Component\\Console\\EventListener\\ErrorListener'],
    $files['Symfony\\Component\\Console\\DependencyInjection\\AddConsoleCommandPass'],
);

foreach ($files as $file) {
    opcache_compile_file($file);
}
