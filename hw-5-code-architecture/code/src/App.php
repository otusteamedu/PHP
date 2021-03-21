<?php

namespace App;

use Repetitor202\HttpJsonResponseFactory;
use Repetitor202\StringValidator;

class App
{
    private HttpJsonResponseFactory $factory;

    private StringValidator $validator;

    public function run()
    {
        $this->factory = new HttpJsonResponseFactory();
        $responseService = $this->factory->build();

        if (isset($_POST['string'])) {
            $this->validator = new StringValidator($_POST['string']);

            if ($this->validator->validate()) {
                $responseService->successOutput();
            } else {
                $responseService->failedOutput($this->validator->getError());
            }
        } else {
            $responseService->failedOutput('Не передан POST-параметр string');
        }
    }
}