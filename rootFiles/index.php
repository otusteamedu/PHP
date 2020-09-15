<?php

require "vendor/autoload.php";

use Controllers\DataBaseControllers\PostgresConnection;
use \Controllers\Orders\CardValidator;
use \Controllers\Orders\Payment;
use Controllers\Orders\PaymentData;
use Logger\Logger;
use \Models\Orders\Order;
use \Source\CurlRequest;
use \Models\Orders\OrdersMapper;
use Source\HttpResponses;

$data = [
    'card_expiration' => '01/21',
    'card_holder' => 'Aleksei Sokolov',
    'card_number' => '1111 1111 1111 1111',
    'cvv' => 123,
    'amount' => 1234
];

$validator = new CardValidator();
$validator->validateCardData($data);

$order = new Order(null, $data['amount']);
$request = new CurlRequest();

$payment = new Payment($data, $order, $request);
$payment->pay();

$postgres = new PostgresConnection();
$connection = new \PDO($postgres->connectionString());

$orderMapper = new OrdersMapper($connection);

try {

    $orderMapper->setOrderIsPaid($order);

} catch (\PDOException $e) {
    Logger::logToFile(PaymentData::LOG_FILE_NAME, $e->getMessage());

    http_response_code(400);

    echo HttpResponses::response(400, $e->getMessage());
}




