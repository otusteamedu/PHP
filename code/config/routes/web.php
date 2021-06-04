<?php

use App\Controller\OpenApiController;
use Slim\App;


return function (App $app) {
    $app->get('/api/doc', OpenApiController::class);
};
