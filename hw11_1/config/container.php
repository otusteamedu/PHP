<?php

declare(strict_types=1);

use App\Services\YouTubeSpider;
use App\Contracts\{IO\Input, IO\Output, YouTubeDriver, Storage};
use App\IO\{StdInput, StdOutput};
use App\Services\YouTubeAuth;
use App\Storage\MongoStorage;
use Dotenv\Dotenv;
use Pimple\Container;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

$dotenv = Dotenv::create('./');
$dotenv->load();

$container = new Container();

$container[Input::class] = function () {
    return new StdInput();
};

$container[Output::class] = function () {
    return new StdOutput();
};

$container[Storage::class] = function () {
    $params = [
        'host' => getenv('MONGO_HOST'),
        'port' => (int)getenv('MONGO_PORT'),
        'db' => getenv('MONGO_DBNAME'),
        'user' => getenv('MONGO_USER'),
        'password' => getenv('MONGO_PASSWORD'),
        'collection' => getenv('MONGO_COLLECTION'),
    ];

    return new MongoStorage($params);
};

$container[YouTubeAuth::class] = function () {
    $secretPath = getcwd() . '/' . getenv('GOOGLE_SECRET_PATH');
    $tokenPath = getcwd() . '/' . getenv('GOOGLE_TOKEN_PATH');

    $scopes = getenv('GOOGLE_SCOPES');
    $scopesArr = json_decode($scopes, true);
    if ($scopesArr === null) {
        $scopes = [$scopes];
    } else {
        $scopes = $scopesArr;
    }

    return new YouTubeAuth($secretPath, $scopes, $tokenPath);
};

$container[YouTubeDriver::class] = function (Container $container) {
    /** @var YouTubeAuth $authService */
    $authService = $container[YouTubeAuth::class];

    $authService->initToken();

    return new \App\Drivers\YouTubeDriver($authService->getClient());
};

$container[YouTubeSpider::class] = function (Container $container) {
    /** @var Input $input */
    $input = $container[Input::class];
    /** @var Output $output */
    $output = $container[Output::class];
    /** @var YouTubeDriver $driver */
    $driver = $container[YouTubeDriver::class];

    return new YouTubeSpider($input, $output, $driver);
};

return $container;
