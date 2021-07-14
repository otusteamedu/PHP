<?php

namespace App;

use App\EmailValidator\EmailValidator;
use App\Exceptions\AppException;
use App\Request\Request;
use App\Response\Response;

class App
{
    /**
     * @throws AppException
     */
    public function run()
    {
        $data = (new Request())->getData();

        if (empty($data['emails']) and !is_array($data['emails'])) {
            throw new AppException('Не передан emails', Response::BAD_REQUEST);
        }

        $validator = new EmailValidator($data['emailss']);
        $validator->validate();
    }
}