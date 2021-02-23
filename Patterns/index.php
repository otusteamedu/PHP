<?php
require_once '../vendor/autoload.php';

use Patterns\AbstractFactory\App;
use Patterns\AbstractFactory\Factory\MilitaryTransportFactory;
use Patterns\AbstractFactory\Factory\PassengerTransportFactory;

abstractFactory();

function abstractFactory()
{
    $type = 'Passenger';

    switch ($type) {
        case 'Passenger':
            $factory = new PassengerTransportFactory();
            break;
        case 'Military':
            $factory = new MilitaryTransportFactory();
            break;
        default:
            echo 'something wrong';
            break;
    }

    $app = new App($factory);
    $app->createTransport();
    $app->forward();
}



