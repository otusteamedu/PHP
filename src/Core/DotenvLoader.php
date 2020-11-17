<?php

namespace App\Core;

use Dotenv\Dotenv;

/**
 * Class DotenvLoader
 * @package App\Configs
 */
class DotenvLoader
{
    public Dotenv $dotenv;

    /**
     * DotenvLoader constructor.
     */
    public function __construct()
    {
        $this->dotenv = Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
        $this->dotenv->load();
        $this->checkRequiredVariables();
    }

    private function checkRequiredVariables(): void
    {
        $this->dotenv->required('RABBITMQ_HOST')->notEmpty();
        $this->dotenv->required('RABBITMQ_PORT')->notEmpty();
        $this->dotenv->required('RABBITMQ_USER')->notEmpty();
        $this->dotenv->required('RABBITMQ_PASSWORD')->notEmpty();
    }

}