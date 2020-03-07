<?php

class App
{
    /**
     * @param array $args
     * @throws Exception
     */
    public function run(array $args): void
    {
        if (!$args[1]) {
            throw new Exception('Need argument');
        }
        $config = parse_ini_file("config.ini", true);
        if ($args[1] === 'client') {
            $client = new Client($config['client']['address'], $config['server']['address']);
            $messages = $client->run();
        } elseif ($args[1] === 'server') {
            $server = new Server($config['server']['address'], $config['client']['address']);
            $messages = $server->run();
        } else {
            throw new Exception('Wrong argument');
        }
        if (!is_null($messages) && $messages instanceof Generator) {
            foreach ($messages as $message) {
                if ($message) {
                    echo $message . PHP_EOL;
                }
            }
        }
    }
}