<?php

namespace App;

use App\Controllers\CheckEmailController;
use App\Controllers\IndexController;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;

class Main
{
    public function run(): void
    {
        $psr17Factory = new Psr17Factory();
        $httpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

        $symfonyRequest = Request::createFromGlobals();
        $request = $httpFactory->createRequest($symfonyRequest);

        if ($symfonyRequest->get('page') === 'check') {
            $response = (new CheckEmailController())->process($request);
        } else {
            $response = (new IndexController())->process($request);
        }

        echo $response->getBody()
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
