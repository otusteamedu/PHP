<?php

namespace App;

use App\Services\Validator;

class App
{
    public function run(array $data)
    {
        $this->runValidation($data);
    }

    private function runValidation(array $value)
    {
        $validator = new Validator($value['string']);
        $validator->validate();
        $validationErrors = $validator->getErrors();
        if ($validationErrors) {
            http_response_code(400);
            echo 'Ошибка - ваша почта не прошла валидацию' . PHP_EOL . PHP_EOL;
            foreach ($validationErrors as $error) {
                echo $error . PHP_EOL;
            }
        } else {
            http_response_code(200);
            echo 'Валидация прошла успешно.';
        }
    }
}