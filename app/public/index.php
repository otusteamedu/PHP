<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;
use Otushw\View;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

try {
    $app = new App();
    $app->run();
}
catch (Exception $e) {
    View::showClient();
    $log = new Logger('app');
    $log->pushHandler(new StreamHandler('app.log'));
    $log->error($e->getMessage());
}
