<?php

require '../vendor/autoload.php';

use Otushw\Brackets;

try {
    $app = new Brackets();
    $app->validation();
}
catch (Exception $e) {

}