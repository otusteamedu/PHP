<?php

class App
{

    public function run(): void
    {
        $stringChecker = new StringChecker();
        try {
            echo $stringChecker->check($_POST);
        } catch (Exception $e) {
            echo $this->handleException($e);
        }
    }

    private function handleException(Exception $e): string
    {
        http_response_code($e->getCode());
        return $e->getMessage();
    }
}