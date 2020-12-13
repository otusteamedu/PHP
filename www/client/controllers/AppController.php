<?php

namespace Controllers;

use Controllers\RouterController;
use Symfony\Component\Dotenv\Dotenv;

class AppController {
    public $env;
    private $router;

    public function __construct()
    {
        $this->env = include_once(__DIR__ . '/bootstrap.php');

        (new Dotenv())->load($this->env['dir']);

        $this->router = new RouterController();
    }

    public function run()
    {
        $this->router->run();
    }
}
