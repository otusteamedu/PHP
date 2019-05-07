<?php

require './vendor/autoload.php';


use HW13_1\DbSeeder;

$dbSeeder = new DbSeeder();

$dbSeeder
    ->seedHall(5)
    ->seedFilm(200)
    ->seedSession(10)
    ->seedClient(500)
    ->seedClientSession(2000)
    ->seedAttributeType()
    ->seedAttribute(200)
    ->seedAttributeValue(10000)
    ->fill();
