<?php
require_once './vendor/autoload.php';

$car = new Vehicles\car();
$plane = new Vehicles\plane();
$tank = new Army\tank();
$solder = new Army\solder();
$car->whereAmI();
$plane->whereAmI();
$tank->whereAmI();
$solder->whereAmI();
