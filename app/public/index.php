<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;
use Otushw\View;
use Otushw\Exception\UserException;
use Otushw\Exception\AppException;
use Otushw\Exception\MapperException;

try {
    $app = new App();
    $app->run();
} catch (UserException $userException) {
    $msg = $userException->getMessage();
    View::showMessage($msg);
} catch (AppException | MapperException $exception) {
    View::showStandardMessage();
}