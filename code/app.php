<?php

require './dotenv.php';

use App\App;

try {
    $app = new App();
    $app->run();
}
catch(Exception $e){

} 