<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Application;

try
{
    $app = new Application();
    $limit = $app->request->get('limit') ? (int) $app->request->get('limit') : 5 ;
    $result = $app->stat->topRateChannels($limit);

    $app->response->send($result);
}
catch (\Throwable $e)
{
   echo $e->getMessage();
}
