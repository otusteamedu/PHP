<?php

require __DIR__ .  '/../bootstrap/bootstrap.php';

use Otushw\App;

try {
    $app = new App();
}
catch (Exception $e) {
    var_dump($e->getMessage());
}
