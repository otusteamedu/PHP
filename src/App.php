<?php


namespace App;


class App
{
    const PARAMS = ['server', 'client'];
    private array $argv;

    /**
     * App constructor.
     * @param $argv
     */
    public function __construct($argv)
    {
        $this->argv = $argv;
    }


    public function run()
    {
        list (, $app) = $this->argv;
        if (! in_array($app, self::PARAMS)) {
            throw new \InvalidArgumentException();
        }

        $socketFile = $_ENV['SOCKET_DIR'] . '/' . $_ENV['SOCKET_FILE'];

        if ($app === 'server') {
            $server = new Server($socketFile);

            $server->listen();
        } else {
            $client = new Client($socketFile);

            $client->waitForMessage();
        }

    }

}
