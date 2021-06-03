<?php
require __DIR__ . '/../vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');

if (!$dotenv->load()) throw new \Dotenv\Exception\InvalidPathException();

return $dotenv->load();