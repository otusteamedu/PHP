<?php

namespace App;

/**
 * Class Application
 * @package App
 */
class Application {

    public function start()
    {
        $data = [
            'email' => $_POST['email']
        ];

        $rules = [
            'email' => 'require|email|mx'
        ];

        $validation = new Validation();

        try {
            $validation->setData($data)->setRules($rules)->make();
        } catch (ValidationException $e) {
            return Message::sendJsonByStatus($e->getMessage(), $e->getCode());
        }

        $errors = $validation->getErrors();
        if(!empty($errors)) return Message::sendJsonErrors($errors);

        return Message::sendJsonOk();
    }
}
