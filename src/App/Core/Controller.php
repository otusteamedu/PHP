<?php

namespace Ozycast\App\Core;

use Ozycast\App\App;

class Controller
{
    /**
     * @var Response|null
     */
    public $response = null;

    public function __construct()
    {
        $this->response = new Response();

        if (static::$auth && !App::getUser()) {
            $this->response->send(false, ['message' => 'Ошибка авторизации'], 401);
            exit;
        }
    }
}