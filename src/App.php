<?php

class App
{

    public function run(): string
    {
        $stringChecker = new StringChecker();
        try {
            return $stringChecker->check($_POST);
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(Exception $e): string
    {
        http_response_code($e->getCode());
        return $e->getMessage();
    }
}