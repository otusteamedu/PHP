<?php

require '../bootstrap.php';

use Penguin\WebCore\App;
use Penguin\Helpers\StatusCode;

try {
    $app = new App();
    $app->run();
} catch (Exception $exception) {
    if (StatusCode::isHttpCode($exception->getMessage())) {
        http_response_code((int)$exception->getMessage());
    } else {
        echo "Ошибка " . $exception->getMessage();
    }

}

