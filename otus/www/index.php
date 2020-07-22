<?php

use App\Controllers\YoutubeChannelController;
use App\Controllers\YoutubeVideoController;
use Classes\Repositories\YoutubeChannelRepositoryImpl;
use Classes\Repositories\YoutubeVideoRepositoryImpl;
use DI\Container;
use Services\YoutubeChannelServiceImpl;
use Services\YoutubeVideoServiceImpl;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();



$container->set(YoutubeVideoRepositoryImpl::class, static function (Container $c) {
    $connection = \Classes\Database\DbConnectionImpl::getConnection(new \Classes\Database\MongoDb());
    return new YoutubeVideoRepositoryImpl($connection);
});

$container->set(YoutubeChannelRepositoryImpl::class, static function (Container $c) {
    $connection = \Classes\Database\DbConnectionImpl::getConnection(new \Classes\Database\MongoDb());
    return new YoutubeChannelRepositoryImpl($connection);
});

$container->set(YoutubeVideoServiceImpl::class, static function (Container $c) {
    $repository = $c->get(YoutubeVideoRepositoryImpl::class);
    return new YoutubeVideoServiceImpl($repository);
});

$container->set(YoutubeChannelServiceImpl::class, static function (Container $c) {
    $repository = $c->get(YoutubeChannelRepositoryImpl::class);
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
$app->post('/channel/create', 'App\Controllers\YoutubeChannelController:createChannel');
$app->post('/channel/delete', 'App\Controllers\YoutubeChannelController:deleteChannelById');

$app->run();
