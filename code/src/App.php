<?php


namespace App;


class App
{
    const MODE = ['server', 'client'];
    private string $mode;
    private string $socketFile;

    /**
     * App constructor.
     * @param $argv
     */
    public function __construct()
    {
        $this->socketFile = $socketFile = $_ENV['SOCKET_DIR'] . '/' . $_ENV['SOCKET_FILE'];

        list(, $mode) = $_SERVER['argv'];

        if (! in_array($mode, self::MODE)) {
            throw new \InvalidArgumentException('Usage: app.php server|client');
        }

        $this->mode = $mode;
    }


    public function run()
    {


        if ($this->mode === 'server') {
            $server = new Server($this->socketFile);

            $server->listen();
        } else {
            $client = new Client($this->socketFile);

            $client->waitForMessage();
        }

    }

}
