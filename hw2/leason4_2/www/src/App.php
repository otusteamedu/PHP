<?php

use helper\ConfigHelper;

class App
{
    public $socketPath;


    public function __construct()
    {
        $config = (new ConfigHelper())->readConfig();
        if ( ! empty($config['listen'])) {
            $this->socketPath = $config['listen'];
        }
    }


    /**
     * Main function
     */
    public function run()
    {
        if (empty($argv)) {
            $argv = $_SERVER['argv'];
        }

        if ( ! isset($argv[1])) {
            $this->writeHelp();
        }
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        switch ($argv[1]) {
            case 'server':
                $sender = new Sender($this->socketPath, true);
                $sender->run();
                break;
            case 'client':
                $sender = new Sender($this->socketPath);
                $sender->run();
                break;
            default:
                $this->writeHelp();
                break;
        }
    }


    /**
     * Print help
     */
    public function writeHelp()
    {
        echo "Usage: php app.php server|client \nserver \t run server side\nclient \t run client side\n\n";
        exit(0);
    }
}