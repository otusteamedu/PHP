<?php

require '../vendor/autoload.php';

use Bracket\Bracket;

try {
    $bracket = new Bracket();
    $bracket->check();
} catch(Exception $e) { 
    echo "message: " . $e->getMessage();
}


