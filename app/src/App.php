<?php

namespace Marchenko;

use Marchenko\Server;
use Marchenko\Client;
use Exception;

class App
{
    protected $type;

    public function __construct(string $type, string $pathConfig)
    {
        $type = htmlspecialchars($type, ENT_QUOTES, 'UTF-8');

        $class = "Marchenko\\" . ucfirst($type);
        if (class_exists($class)) {
            $this->type = new $class($pathConfig);
        } else {
            throw new Exception('Unsupported type');
        }
    }

    public function run()
    {
        $this->type->run();
    }
}
