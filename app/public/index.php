<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;
use Otushw\Message;
use Otushw\Exception\AppException;

try {
    $app = new App();
    $app->run();
} catch (AppException $exception) {
    Message::showMessage($exception->getMessage());
}