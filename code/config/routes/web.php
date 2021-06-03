<?php

use App\Controller\ApidocController;
use Slim\App;


return function (App $app) {
    $app->get('/api/doc', ApidocController::class);
};
