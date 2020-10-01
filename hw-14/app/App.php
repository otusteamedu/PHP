<?php

namespace App;

use App\Cli\Router;
use Otus\DBConnection;

class App
{
    private Router $router;
    private DBConnection $db;

    public function __construct()
    {
        $this->router = new Router();
        $this->db = DBConnection::getInstance();
    }

    public function run()
    {
    }
}
