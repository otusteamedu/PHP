<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Db\TableGateway;
use App\Service\Rand;

if (!isset($argv[1])) {
    throw new InvalidArgumentException('No argument specified');
}

$count = $argv[1];

$types = [
    'integer_value',
    'time_value',
    'date_value',
    'timestamp_value',
    'text_value',
    'boolean_value'
];

//--- Init tables ---------------------------------------------------

$attribute = new TableGateway('attribute', [
    'name',
    'attribute_type_id',
]);

$attributeType = new TableGateway('attribute_type', [
    'name',
]);

$attributeValue = new TableGateway('attribute_value', $types);

$customer = new TableGateway('customer', [
    'name',
]);

$film = new TableGateway('film', [
    'name',
]);

$filmAttribute = new TableGateway('film_attribute', [
    'film_id',
    'attribute_id',
    'attribute_value_id',
]);

$hall = new TableGateway('hall', [
    'name',
    'seats',
]);

$seance = new TableGateway('seance', [
    'film_id',
    'hall_id',
    'seance_time',
    'price'
]);

$ticket = new TableGateway('ticket', [
    'customer_id',
    'seance_id',
    'purchase_date',
    'seat'
]);
//exit;
//--- Fill tables ---------------------------------------------------

//attribute_type
foreach ($types as $type) {
    $attributeType->insert(['name' => str_replace('_value', '', $type)]);
}

//attribute
for ($i = 0; $i < $count/10; $i++) {
    $attribute->insert([
        'name' => Rand::getRandStr(10) . $i,
        'attribute_type_id' => Rand::getRandInt(1, 6),
    ]);
}

//attribute_value
for ($i = 0; $i < $count/10; $i++) {
    $date = Rand::getRandInt(1970, 2019) . '-' .
        sprintf("%02d",Rand::getRandInt(1, 12)) . '-' .
        sprintf("%02d",Rand::getRandInt(1, 30));
    $time = sprintf("%02d",Rand::getRandInt(0, 23)) . ':' .
        sprintf("%02d",Rand::getRandInt(0, 59)) . ':' .
        sprintf("%02d",Rand::getRandInt(0, 59));
    $ind = Rand::getRandInt(1, 6);
    $attributeValue->insert([
        'integer_value' => $ind == 1 ? Rand::getRandInt(0, 10000) : null,
        'time_value' => $ind == 2 ? $time : null,
        'date_value' => $ind == 3 ?$date : null,
        'timestamp_value' => $ind == 4 ? $date . ' ' . $time : null,
        'text_value' => $ind == 5 ? Rand::getRandStr(500) : null,
        'boolean_value' => $ind == 6 ? Rand::getRandBool() : null,
    ]);
}

//film
for ($i = 0; $i < $count/10; $i++) {
    $film->insert([
        'name' => Rand::getRandStr(10) . $i,
    ]);
}

//hall
for ($i = 0; $i < $count/100; $i++) {
    $hall->insert([
        'name' => Rand::getRandStr(10) . $i,
        'seats' => Rand::getRandInt(100, 500),
    ]);
}

//customer
for ($i = 0; $i < $count/10; $i++) {
    $customer->insert([
        'name' => Rand::getRandStr(10) . $i,
    ]);
}

//seance
for ($i = 0; $i < $count/10; $i++) {
    $date = Rand::getRandInt(1970, 2019) . '-' .
        sprintf("%02d",Rand::getRandInt(1, 12)) . '-' .
        sprintf("%02d",Rand::getRandInt(1, 30));
    $time = sprintf("%02d",Rand::getRandInt(0, 23)) . ':' .
        sprintf("%02d",Rand::getRandInt(0, 59)) . ':' .
        sprintf("%02d",Rand::getRandInt(0, 59));
    $seance->insert([
        'film_id' => Rand::getRandInt(1, $count/10 - 1),
        'hall_id' => Rand::getRandInt(1, $count/100 - 1),
        'seance_time' => $date . ' ' . $time,
        'price' => Rand::getRandInt(150, 500),
    ]);
}

//film_attribute ???
for ($i = 0; $i < $count/10; $i++) {
    $filmAttribute->insert([
        'film_id' => Rand::getRandInt(1, $count/10 - 1),
        'attribute_id' => Rand::getRandInt(1, $count/10 - 1),
        'attribute_value_id' => Rand::getRandInt(1, $count/10 - 1),
    ]);
}

//ticket
for ($i = 0; $i < $count/10; $i++) {
    $date = Rand::getRandInt(1970, 2019) . '-' .
        sprintf("%02d",Rand::getRandInt(1, 12)) . '-' .
        sprintf("%02d",Rand::getRandInt(1, 30));
    $time = sprintf("%02d",Rand::getRandInt(0, 23)) . ':' .
        sprintf("%02d",Rand::getRandInt(0, 59)) . ':' .
        sprintf("%02d",Rand::getRandInt(0, 59));
    $ticket->insert([
        'customer_id' => Rand::getRandInt(1, $count/10 - 1),
        'seance_id' => Rand::getRandInt(1, $count/10 - 1),
        'purchase_date' => $date . ' ' . $time,
        'seat' => Rand::getRandInt(100, 500),
    ]);
}
