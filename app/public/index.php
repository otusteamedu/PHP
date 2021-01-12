<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;
use Otushw\View;

use Otushw\UserException;
use Otushw\AppException;

try {
    $app = new App();
    $app->run();
} catch (UserException $userException) {
    $msg = $userException->getMessage();
    View::showMessage($msg);
} catch (AppException $exception) {
    View::showClient();
}
