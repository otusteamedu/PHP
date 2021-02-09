<?php

require __DIR__ . '/../vendor/autoload.php';

use Otushw\App;
use Otushw\Message;
use Otushw\Exception\AppException;

try {
    $app = new App();
    $app->run();
} catch(Exception $e) {
    Message::showMessage($e->getMessage());
}
