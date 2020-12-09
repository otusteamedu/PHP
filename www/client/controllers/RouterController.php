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
        $api = $this->api;

        $this->router->get('/insert', function() use ($api){
            echo json_encode($api->insert());
        });

        $this->router->get('/get/{id}', function(string $id) use ($api){
            echo json_encode($api->get($id)); 
        });

        $this->route->run();
    }
}
