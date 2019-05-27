<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Db\TableGateway;
use App\Service\Rand;

if (!isset($argv[1])) {
    throw new InvalidArgumentException('No argument specified');
}

$attributeTable = new TableGateway('attribute', ['name', 'attribute_type_id']);
$attributeTypeTable = new TableGateway('attribute_type', ['name']);
$attributeValueTable = new TableGateway('attribute_value', ['integer_value', 'time_value', 'date_value',
    'timestamp_value', 'text_value', 'boolean_value']);
$customerTable = new TableGateway('customer', ['name']);
$filmTable = new TableGateway('film', ['name']);
$filmAttributeTable = new TableGateway('film_attribute', ['film_id', 'attribute_id', 'attribute_value_id']);
$hallTable = new TableGateway('hall', ['name', 'seats']);
$seanceTable = new TableGateway('seance', ['film_id', 'hall_id', 'seance_time', 'price']);
$ticketTable = new TableGateway('ticket', ['customer_id', 'seance_id', 'purchase_date', 'seat']);

//attribute_type
foreach (['integer', 'time', 'date', 'timestamp', 'text', 'boolean'] as $type) {
    $attributeTypeTable->insert(['name' => $type]);
}

for ($i = 0; $i < 10; $i++) {

}

for ($i = 0; $i < $argv[1]; $i++) {
    $filmId = $filmTable->insert(['name' => 'Film' . $i]);
    $customerId = $customerTable->insert(['name' => 'Customer' . $i]);
    $hallId = $hallTable->insert(['name' => 'Hall' . $i, 'seats' => Rand::getRandInt(100, 500)]);
}



