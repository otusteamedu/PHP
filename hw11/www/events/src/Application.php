<?php

namespace App;

use App\Messages\MessageCLI;
use App\Repositories\ChannelRepository;
use App\Routes\Route;
use App\Services\YoutubeApiService;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use RuntimeException;

/**
 * Class Application
 * @package App
 */
class Application {

    public function start(): void
    {
        $router = new Route();
        $router->init();
    }
}
