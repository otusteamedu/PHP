<?php

namespace App;

use Repetitor202\HttpJsonResponseService;
use Repetitor202\IResponseService;
use Repetitor202\StringValidator;

class App
{
    private IResponseService $responseService;

    private StringValidator $validator;

    public function run()
    {
        $this->responseService = new HttpJsonResponseService();

        if (isset($_POST['string'])) {
            $this->validator = new StringValidator($_POST['string']);

            if ($this->validator->validate()) {
                $this->responseService->successOutput();
            } else {
                $this->responseService->failedOutput($this->validator->getError());
            }
        } else {
            $this->responseService->failedOutput('Не передан POST-параметр string');
        }
    }
}