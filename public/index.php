<?php

use Framework\App;

chdir(dirname(__DIR__));

require_once 'vendor/autoload.php';

(function () {
    $app = new App();
    $app->run();
})();
