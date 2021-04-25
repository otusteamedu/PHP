<?php


namespace App\Console\Commands;


use App\Console\CommandContract;
use App\Container;
use App\Sockets\Client;
use App\Sockets\Server;
use App\Sockets\Socket;
use App\Sockets\SocketConfig;
use App\Sockets\UnixSocket;

class SocketCommand implements CommandContract
{


    private $type, $port, $path, $domain;
    const DOMAIN_TCP = 'TCP';
    const TYPE_CLIENT = 'client';
    const TYPE_SERVER = 'server';


    public function __construct(array $arguments = [])
    {
        $this->type = (string)current($arguments);
        $this->path = next($arguments) ? current($arguments) : null;
        $this->port = next($arguments) ? current($arguments) : null;
        $this->domain = next($arguments) ? current($arguments) : null;
    }

    public function handle()
    {
        $config = Container::make(SocketConfig::class)
            ->setAddress($this->path ?? getenv('SOCKET_PATH'))
            ->setPort($this->port ?? getenv('SOCKET_PORT'));
        $socket = $this->domain === self::DOMAIN_TCP ? new Socket($config) : new UnixSocket($config);
        switch ($this->type) {
            case self::TYPE_CLIENT:
                (new Client($socket))->connect();
                break;
            case self::TYPE_SERVER:
                (new Server($socket))->listen();
                break;
            default:
                throw new \InvalidArgumentException('Wrong type');
        }
    }
}