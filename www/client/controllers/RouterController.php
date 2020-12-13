<?php

namespace Controllers;

use Bramus\Router\Router;
use Controllers\ApiController;

class RouterController {
    private $router;
    private $api;

    public function __construct()
    {
        $this->router = new Router();
        $this->api = new ApiController();    
    }        

    public function run()
    {
        $this->insert();
        $this->get();

        $this->route->run();
    }

    private function insert() : void
    {
        $api = $this->api;

        $this->router->get('/insert', function() use ($api){
            echo json_encode($api->insert());
        });
    }

    private function get() : void
    {
        $api = $this->api;

        $this->router->get('/get/{id}', function(string $id) use ($api){
            echo json_encode($api->get($id)); 
        });
    }
}
