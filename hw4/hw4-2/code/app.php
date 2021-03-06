<?php
require_once './bootstrap/app.php';

use Src\Client;
use Src\Server;

try {
    $role = isset($argv[1]) ? $argv[1] : null;
    if (!empty($role)) {
        if ($role == 'client') {
            $app = new Client(
                './otus.sock',
                9999
            );
            $app->waitForMessage();
        } else {
            $app = new Server(
                './otus.sock',
                9999
            );
            $app->listen();
        };
    } else {
        throw new \Exception('Socket role must be set.' . PHP_EOL);
    }
} catch (\Exception $e) {
    header('HTTP/1.0 400 Bad Request');
    echo $e->getMessage();
}
