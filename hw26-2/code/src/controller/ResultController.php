<?php

namespace TimGa\hw26\controller;

use TimGa\hw26\model\ResultModel;
use TimGa\hw26\model\RequestModel;
use TimGa\hw26\validator\ResultCheckInputValidator;

class ResultController
{

    public function checkResult()
    {
        $requestId = filter_input(INPUT_POST, 'request_id', FILTER_VALIDATE_INT);
        $validator = new ResultCheckInputValidator;
        if (!$validator->isValid($requestId)) {
            include ROOT . "/src/view/validator.php";
            exit();
        }

        if ((new RequestModel)->requestExists($requestId)) {
            $result = (new ResultModel)->selectResultFromDbByRequestId($requestId);
        }

        include ROOT . "/src/view/result.php";
    }

}
