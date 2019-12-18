<?php

declare(strict_types=1);

use Bracketed\Resolver;
use Controller\IndexController;
use Service\StringChecker;

class App
{
    public function run(): void
    {
        $resolver = new Resolver();
        $stringChecker = new StringChecker($resolver);
        $controller = new IndexController();

        try {
            echo $controller->processRequest($stringChecker, $_POST);
        } catch (Throwable $exception) {
            echo $this->handleException($exception);
        }
    }

    private function handleException(Throwable $exception): string
    {
        http_response_code($exception->getCode());

        return $exception->getMessage();
    }
}
