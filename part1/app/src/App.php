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
        $validator = new Validator();
        if ($validator->isValid($_POST['string'])) {
            Responser::response();
        }
    }
}