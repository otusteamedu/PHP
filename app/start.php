<?php
require_once __DIR__ . '/../bootstrap/init.php';
echo "<pre>";
$controller = "src\Controllers\\"
    . explode("?" ,explode("/", $_SERVER['REQUEST_URI'])[1])[0]
    . "Controller";
if (class_exists($controller)) {
    $method = explode("/", $_SERVER['REQUEST_URI'])[2] ?? "run";
    if ($method != "run") {
        $request = explode('?', $method);
        $method = $request[0];
        unset($request[0]);
        $params = $request;
    }
    try {
        $app = new $controller();
        if (method_exists($app, $method)) {
            $app->{$method}();
        }
    } catch (Exception $exception) {
        echo "Code:" . $exception->getCode() . ". " . $exception->getMessage() . PHP_EOL;
        http_response_code((int)$exception->getCode());
    }
}
echo "Good Bye" . PHP_EOL;
