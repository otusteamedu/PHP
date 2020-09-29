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
        $this->db = new DBConnection();
    }

    public function run()
    {
        $query = $this->db->prepare('SELECT * FROM "seances" LIMIT 50 ');
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute();
        $result = $query->fetchAll();
        var_dump($result);
//        $this->router->resolve();
    }
}
