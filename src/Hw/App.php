<?php
namespace Hw4;

use Hw4\Server;
use League\CLImate\CLImate;

class App {

    private $climate;
    private $mode;

    public function __construct() {
        $this->setMode();
        $this->climate = new CLImate;
    }

    private function getMode() {
        return $this->mode;
    }
    private function setMode() {
        $params = $this->parseParams();
        if ($params['m'] == "client" || $params['mode'] == "client") {
            $this->mode = "client";
        } elseif ($params['m'] == "server" || $params['mode'] == "server") {
            $this->mode = "server";
        } else {
            $this->mode = "help";
        }
    }

    public function run() {
        if ($this->getMode() == "client") {
            $this->climate->green("Start in client mode");
            $client = new Client;
            $client->run();
        } elseif ($this->getMode() == "server") {
            $this->climate->red("Start in server mode");
            $server = new Server;
            $server->run();
        } else {
            $this->showHelp();
        }
    }

    private function parseParams() {
        $options = "";
        $options.= "m:";    // mode: client|server
        $options.= "h";     // help: startup options

        $longOpts = [
            "mode:",        // mode: client|server
            "help",         // help: startup options
        ];
        return getopt($options, $longOpts);
    }


    private function showHelp() {
        $this->climate->backgroundDarkGray()->white('use -m or --mode with value "server" or "client" to run in correspondent mode');
    }
}