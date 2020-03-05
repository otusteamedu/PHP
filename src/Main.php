<?php

namespace App;

use App\Controllers\CheckEmailController;
use App\Controllers\IndexController;
use Symfony\Component\HttpFoundation\Request;

class Main
{
    public function run(): void
    {
        $request = Request::createFromGlobals();

        if ($request->get('page') === 'check') {
            $response = (new CheckEmailController())->process($request);
        } else {
            $response = (new IndexController())->process($request);
        }

        echo $response->getContent()
            . "<br><br>Ответил сервер: <b>{$this->getServerName()}</b>";
    }

    /**
     * @return string
     */
    private function getServerName(): string
    {
        return $_SERVER['SERVER_NAME'] ?? 'Server undefined';
    }
}
