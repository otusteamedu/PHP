<?php
require_once __DIR__ . '/../bootstrap/init.php';
//header('HTTP/1.0 400 Bad Request', true, 400);

$route = "Controllers\\" . explode("?" ,explode("/", $_SERVER['REQUEST_URI'])[1])[0];
if (class_exists($route)) {
   try {
        $app = new $route();
        $app->run();
    } catch (Exception $exception) {
        http_response_code($exception->getCode());
        echo "Code:" . $exception->getCode() . ". " . $exception->getMessage() . PHP_EOL;
    }
}
echo "Good Bye" . PHP_EOL;
