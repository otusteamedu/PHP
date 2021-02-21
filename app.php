<?php

use App\App;
use App\Validators\BracketValidator;
use App\Validators\EmailValidator;

require_once __DIR__ . '/vendor/autoload.php';
try {
    $app = new App();
    echo $app->run();
} catch (Throwable $e) {

}
