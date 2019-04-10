<?php

require ("./vendor/autoload.php");

use nvggit\Check;

$check = new Check();

while(true) {
    echo $check->exec(fgets(STDIN));
}
