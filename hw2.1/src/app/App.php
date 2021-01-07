<?php

namespace App;

use App\Validator\RequestValidator;

/**
 * Class App
 * @package App
 */
class App
{
    /**
     * run application
     */
    public function run()
    {
        $validator = new RequestValidator();
        $value = $_POST['string'] ?? null;

        if ($validator->isValid($value)) {
            $this->response('String is valid');
            return;
        }

        $this->response('String is not valid', 400);
    }

    /**
     * @param $message
     * @param int $httpCode
     * @return void
     */
    private function response($message, $httpCode = 200): void
    {
        http_response_code($httpCode);
        echo $message;
    }
}
