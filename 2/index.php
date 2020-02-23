<?php
require_once 'vendor/autoload.php';

use App\Brackets;

$data = '
    ()()())()
    ()()()()
    )))()()(
    ()()()
';

echo (new Brackets())->isValid($data);