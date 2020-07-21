<?php

use App\Controllers\YoutubeChannelController;
use App\Controllers\YoutubeVideoController;
use Classes\Repositories\YoutubeChannelRepository;
use Classes\Repositories\YoutubeVideoRepository;
use DI\Container;
use Services\YoutubeChannelServiceImpl;
use Services\YoutubeVideoServiceImpl;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();



$container->set(YoutubeVideoRepository::class, static function (Container $c) {
    $connection = \Classes\Database\DbConnectionImpl::getConnection(new \Classes\Database\MongoDb());
    return new YoutubeVideoRepository($connection);
});

$container->set(YoutubeChannelRepository::class, static function (Container $c) {
    $connection = \Classes\Database\DbConnectionImpl::getConnection(new \Classes\Database\MongoDb());
    return new YoutubeChannelRepository($connection);
});

$container->set(YoutubeVideoServiceImpl::class, static function (Container $c) {
    $repository = $c->get(YoutubeVideoRepository::class);
    return new YoutubeVideoServiceImpl($repository);
});

$container->set(YoutubeChannelServiceImpl::class, static function (Container $c) {
    $repository = $c->get(YoutubeChannelRepository::class);
    return new YoutubeChannelServiceImpl($repository);
});

$container->set(YoutubeVideoController::class, static function (Container $c) {
    $videoService = $c->get(YoutubeVideoServiceImpl::class);
    return new YoutubeVideoController($videoService);
});

$container->set(YoutubeChannelController::class, static function (Container $c) {
    $videoService = $c->get(YoutubeChannelServiceImpl::class);
    return new YoutubeChannelController($videoService);
});


$app->post('/video/create', 'App\Controllers\YoutubeVideoController:createVideo');
$app->post('/video/delete', 'App\Controllers\YoutubeVideoController:deleteVideoById');


$app->run();
