<?php

namespace App;

use App\Cli\Router;
use App\Repositories\FilmsRepository;
use Otus\DBConnection;

class App
{
    private Router $router;
    private DBConnection $db;

    public function __construct()
    {
        $this->router = new Router();
        $this->db = new DBConnection();
    }

    public function run()
    {

    }
}
