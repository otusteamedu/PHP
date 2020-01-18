<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;

class ExceptionHandler
{
    /** @var Config $config */
    private $config;

    /**
     * @var string|null
     */
    private $env;

    public function __construct()
    {
        $this->config = new Config();
        $this->env = $this->config->getEnvironment();
    }

    public static function errorHandler(\Throwable $e)
    {
        $config = new Config();

        if ($config->getEnvironment() == 'dev') {
            $data = [
                'error' => "message: {$e->getMessage()}, file: {$e->getFile()}, line: {$e->getLine()}"
            ];
        } else {
            $data = [
                'error' => 'Во время работы возникла ошибка. Обратитесь пожалуйста в тех.поддержку'
            ];
        }

        $response = new Response($data);
        $response->send();
    }
}