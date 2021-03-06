<?php

namespace App;

/**
 * Class App
 *
 * @package App
 */
class App
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $string = $_POST['string'];
        $validator = new Validator();
        if ($validator->isValid($string)) {
            http_response_code(200);
            echo 'String is valid';
        }
    }
}