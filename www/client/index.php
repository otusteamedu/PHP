<?php

use Symfony\Component\Dotenv\Dotenv;
use Bramus\Router\Router;
use Controllers\ApiController;

include_once(__DIR__ . '/vendor/autoload.php');

(new Dotenv())->load(__DIR__ . '/.env');

try {
    $route = new Router();
    $api = new ApiController();

    $route->get('/insert', function() use ($api){
        echo json_encode($api->insert());
    });

    $route->get('/get/{id}', function(string $id) use ($api){
        echo json_encode($api->get($id)); 
    });

    $route->run();
} catch (Exception $e) {
   echo json_encode(['error' => 'Выброшено исключение: ' . $e->getMessage() ]);
}



