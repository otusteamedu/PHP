<?php

require '../vendor/autoload.php';

use Bracket\Bracket;

try {
    $bracket = new Bracket();
    $bracket->check($_POST);
} catch(Exception $e) { 
    echo "message: " . $e->getMessage();
}


