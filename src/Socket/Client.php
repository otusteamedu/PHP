<?php

namespace Tirei01\Hw4\Socket;

use Tirei01\Hw4\Config;

class Client extends Socket
{
    protected function getServerSocket()
    {
        $obConfig = new Config('server');
        return sys_get_temp_dir() . "/" . $obConfig->get('socket_name') . ".sock";
    }

    public function loop()
    {
        $this->bind();
        while (false !== ($line = fgets(STDIN))) {
            $line = trim($line);
            if ($line === 'exit') {
                break;
            }
            $line = trim($line);
            if ($line) {
                $this->nonBlock();
                $this->send($line, $this->getServerSocket());
                $this->block();
                $this->get();
                echo $this->getMessage();
                echo PHP_EOL;
            }

        }
    }
}