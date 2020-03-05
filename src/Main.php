<?php

namespace App;

class Main
{
    public function run(): void
    {
        echo "Ответил сервер: <b>{$this->getServerName()}</b>";
    }

    /**
     * @return string
     */
    private function getServerName(): string
    {
        return $_SERVER['SERVER_NAME'] ?? 'Server undefined';
    }
}
