<?php
declare(strict_types=1);

use App\App;
use App\Http\Response;
use App\Http\Exception\HttpException;

require dirname(__DIR__).'/vendor/autoload.php';

try {
    $response = (new App())->run();

    $response->send();
} catch (\Throwable $e) {
    if ($e instanceof HttpException) {
        (new Response($e->getMessage(), $e->getStatusCode()))
            ->send();
    } else {
        (new Response(null, 500))
            ->send();
    }
}
