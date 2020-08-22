<?php

require __DIR__ . '/../vendor/autoload.php';

use Penguin\WebCore\App;
use Penguin\Helpers\StatusCode;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    if (StatusCode::isHttpCode((int)$exception->getMessage())) {
        http_response_code((int)$exception->getMessage());
    } else {
        echo "Ошибка " . $exception->getMessage();
    }

}

