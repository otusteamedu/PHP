<?php

namespace App;

use App\Bracket\BracketValidator;
use App\Exceptions\RequestException;

class App
{
    /**
     * @throws RequestException
     */
    public function run()
    {
        $data = (new Request())->getData();

        if (empty($data['string'])) {
            throw new RequestException('Не передан string', 400);
        }

        $validator = new BracketValidator($data['string']);
        $validator->check();
    }
}