<?php

namespace TimGa\hw26\controller;

use TimGa\hw26\model\RequestModel;
use TimGa\hw26\rabbitmq\RabbitmqFairDispatch;
use TimGa\hw26\validator\RequestInputValidator;

class RequestController
{

    public function createNewRequest()
    {
        $userInputValue = filter_input(INPUT_POST, 'user_input_value', FILTER_VALIDATE_INT);
        $validator = new RequestInputValidator;
        if (!$validator->isValid($userInputValue)) {
            include ROOT . "/src/view/validator.php";
            exit();
        }

        $requestId = (new RequestModel)->insertUserRequestIntoDb($userInputValue);
        $dataToPublish = json_encode([$requestId, $userInputValue]);

        $rabbitmq = new RabbitmqFairDispatch;
        $rabbitmq->publishData($dataToPublish, 'user_requests');
        $rabbitmq->close();

        include ROOT . "/src/view/request.php";
    }

}
