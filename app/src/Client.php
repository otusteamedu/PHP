<?php


namespace Marchenko;

use Marchenko\BaseSocket;
use Exception;

class Client extends BaseSocket
{
    public function __construct(string $pathConfig)
    {
        parent::__construct($pathConfig);

        if (!file_exists($this->pathSocket)) {
            return new Exception('Does not exist socket. Please run server.');
        }

        if (!socket_connect($this->socket, $this->pathSocket)) {
            return new Exception('Can\'t connect socket');
        }
    }

    public function run()
    {
        $this->write('Hello');
    }

    private function write($value)
    {
        $len = strlen($value);
        while (true) {
            $num = socket_write($this->socket, $value);
            if ($num < $len) {
                $value = substr($value, $num);
                $len -= $num;
            } else {
                break;
            }
        }
    }
}
