<?php


use AYakovlev\Exception\CliException;

require __DIR__ . "/../vendor/autoload.php";

try {
    unset($argv[0]);

    $className = '\\AYakovlev\\cli\\' . array_shift($argv);
    if (!class_exists($className)) {
        throw new CliException('Class "' . $className . '" not found');
    }

    $params = [];
    foreach ($argv as $argument) {
        preg_match('/^-(.+)=(.+)$/', $argument, $matches);
        if (!empty($matches)) {
            $paramName = $matches[1];
            $paramValue = $matches[2];

            $params[$paramName] = $paramValue;
        }
    }

    // Create class instance from cli, send params and call execute() method
    $class = new $className($params);
    $class->execute();
} catch (CliException $e) {
    echo 'Error: ' . $e->getMessage();
}