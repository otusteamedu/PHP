<?php

namespace Src;

use Klein\Klein;
use Klein\Request;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Class Route
 *
 * @package App\Routes
 */
class Route
{
    /**
     * @var Klein
     */
    private Klein $router;

    private ?array $argv;

    public function __construct(?array $argv)
    {
        $this->router = new Klein();
        $this->argv = $argv;
    }

    /**
     * @throws \Exception
     */
    public function init(): void
    {
        if (!empty($this->argv)) {
            if (isset($this->argv[1]) && $this->argv[1] === 'consumer') {
                $consumer = new Consumer();
                $consumer->listen();
            }
            throw new \Exception('Service not found');
        } else {
            $this->router->respond(
                'POST',
                '/add',
                static function (Request $request) {
                    Validator::validate($request->params());
                    $publisher = new Publisher();
                    $publisher->send($request->param('email'));
                });

            $this->router->dispatch();
        }
    }
}