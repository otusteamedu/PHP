<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use Pimple\Container;
use RowDataGateway\Gateways\{FilmGateway, GenreGateway};
use RowDataGateway\Finders\{FilmFinder, GenreFinder};

chdir(dirname(__DIR__));
require_once 'vendor/autoload.php';

$dotenv = Dotenv::create('./');
$dotenv->load();

$container = new Container();

$container[PDO::class] = function () {
    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $name = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
};

$container[FilmGateway::class] = function (Container $c) {
    return new FilmGateway($c[PDO::class]);
};
$container[GenreGateway::class] = function (Container $c) {
    return new GenreGateway($c[PDO::class]);
};
$container[FilmFinder::class] = function (Container $c) {
    return new FilmFinder($c[PDO::class], $c[FilmGateway::class], $c[GenreFinder::class]);
};
$container[GenreFinder::class] = function (Container $c) {
    return new GenreFinder($c[PDO::class], $c[GenreGateway::class]);
};

return $container;
