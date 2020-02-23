<?php

namespace App;

use Dotenv\Dotenv;
use Exception;

/**
 * Class Application
 * @package App
 */
class Application
{

    const TYPE_CLIENT = 'client';
    const TYPE_SERVER = 'server';

    /**
     * @throws Exception
     */
    public function start()
    {
        if(!$this->checkArgType())
            throw new Exception('Missing argument "--type='.self::TYPE_CLIENT.'" or "--type='.self::TYPE_SERVER.'');

        if (!file_exists(dirname(__DIR__) . '/.env'))
            throw new \RuntimeException('missing environment file .env.');

        (Dotenv::createImmutable(dirname(__DIR__) , '/.env'))->load();

        if(!getenv('FILE_PATH_SOCKET_SERVER'))
            throw new Exception('missing from the env file "FILE_PATH_SOCKET_SERVER".');

        if(!getenv('FILE_PATH_SOCKET_CLIENT'))
            throw new Exception('missing from the env file "FILE_PATH_SOCKET_CLIENT".');

        if (!extension_loaded('sockets'))
            throw new Exception('The sockets extension is not loaded.');

        $type = $this->getType();

        if($type == 'server') {
            (new Server())->start();
        } elseif($type == 'client') {
           (new Client())->start();
        }
    }

    /**
     * @return bool
     */
    public function checkArgType()
    {
        if($_SERVER['argc'] < 2) return false;

        foreach ($_SERVER['argv'] as $argv) {
            if((strpos($argv, 'type') !== false
                    && strpos($argv, self::TYPE_CLIENT) !== false)
                || (strpos($argv, 'type') !== false
                    && strpos($argv, self::TYPE_SERVER) !== false)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    private function getType()
    {
        foreach ($_SERVER['argv'] as $argv) {
            if(strpos($argv, 'type') !== false && strpos($argv, self::TYPE_CLIENT) !== false)
                return self::TYPE_CLIENT;
            if(strpos($argv, 'type') !== false && strpos($argv, self::TYPE_SERVER) !== false)
                return self::TYPE_SERVER;
        }
        return '';
    }
}
