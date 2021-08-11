<?php


namespace app;


use Exception;

class StartSocket
{
    /**
     * @throws Exception
     */
    public function run($argv)
    {
        $possibleArguments = [
            'client' => 'cli/client.php',
            'server' => 'cli/server.php',
        ];
        error_reporting(E_ERROR);
        if (!isset($argv[1])) {
            throw new Exception("Отсутствует аргумент.");
        }
        if (!isset($possibleArguments[$argv[1]])) {
            throw new Exception("Неверный аргумент.");
        }
        $load = $possibleArguments[$argv[1]];
        if (!file_exists($load)) {
            throw new Exception("Отсутствует файл $load");
        }
        require_once $load;
    }
}
