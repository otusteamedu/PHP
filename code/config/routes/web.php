<?php

use Slim\App;

return function (App $app) {
    $app->get('/', 'App\Controller\HomeController:index');
};
