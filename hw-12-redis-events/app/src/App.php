<?php

namespace App;

use App\Router\Router;

class App
{
    /**
     * run the app
     */
    public function run (): string
    {
        $payload = $_POST['q'] ?? '';

        return Router::dispatch(strval($payload));
    }
}