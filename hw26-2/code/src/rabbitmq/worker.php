<?php

require_once 'vendor/autoload.php';

use TimGa\hw26\model\ResultModel;
use TimGa\hw26\rabbitmq\RabbitmqFairDispatch;

$callback = function($msg) {

    // get data from rabbitmq message
    $publishedData = json_decode($msg->body);
    $requestId = $publishedData[0];
    $userInputValue = $publishedData[1];

    // executing some business logic
    sleep($userInputValue);
    $result = "Request is ready! RequestID: $requestId Input value: $userInputValue";

    // insert result into db
    (new ResultModel)->insertResultIntoDb($requestId, $result);


    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};


$rabbitmq = new RabbitmqFairDispatch;
$rabbitmq->consumeData('user_requests', $callback);

$rabbitmq->close();

