<?php
namespace Deadly117;

use Exception;
use Deadly117\Config;
use Deadly117\Socket\Server;
use Deadly117\Socket\Client;

class App
{
    private $cfg;
    private $mode;

    public function __construct()
    {
        $this->cfg = new Config('config.ini');

        $shortopts = 'm:';
        $longopts = ['mode:'];
        $options = getopt($shortopts, $longopts);
        $this->mode = $options['m'] ?? $options['mode'];
    }

    public function run()
    {
        switch ($this->mode) {
            case 'server':
                $server = new Server($this->cfg);
                $server->run();
                break;
            case 'client':
                $client = new Client($this->cfg);
                $client->run();
                break;
            default:
                throw new Exception("unknown mode [{$this->mode}]");
                break;
        }
    }
}