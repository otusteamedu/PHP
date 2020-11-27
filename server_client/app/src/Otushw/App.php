<?php

namespace Otushw;

use Exception;

class App
{
    const ALLOWED_SERVER = 'cli';
    const ALLOWED_TYPE = ['server', 'client'];

    protected $type;
    protected $config;

    public function __construct()
    {
        global $argv;
        $this->validation($argv);
        $this->type = $argv[1];
    }

    protected function validation($argv)
    {
        if (php_sapi_name() != self::ALLOWED_SERVER) {
            throw new Exception('Server only allowed: ' . self::ALLOWED_SERVER);
        }
        if (!isset($argv[1])) {
            throw new Exception('To run the script, need the parameter.');
        }
        if (empty($argv[1])) {
            throw new Exception('Parameter is empty.');
        }
        if (!in_array($argv[1], self::ALLOWED_TYPE)) {
            throw new Exception('Invalid parameter value. Allowed "server" or "client"');
        }
    }

    public function run()
    {
        $app = $this->create($this->type, $this->config);
        $app->run();
    }

    private static function create($type, $config)
    {
        switch ($type) {
            case 'server':
                return new Server();
            case 'client':
                return new Client();
        }
    }

}