<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;
use Otushw\Message;

try {
    $app = new App();
    $app->run();
} catch(Exception $e) {
    Message::showMessage($e->getMessage());
}
