<?php


namespace App\Console\Commands;


use App\Sockets\Client;
use App\Sockets\Server;
use App\Sockets\Socket;
use App\Sockets\SocketConfig;
use App\Sockets\UnixSocket;
use Illuminate\Console\Command;
use Illuminate\Container\Container;

abstract class SocketCommand extends Command
{


    public const DOMAIN_TCP = 'TCP';
    public const TYPE_CLIENT = 'client';
    public const TYPE_SERVER = 'server';

    protected $signature = 'socket:create  {type} {path?} {port?} {domain?}';


    public function handle(): void
    {
        $config = Container::getInstance()->make(SocketConfig::class)
            ->setAddress($this->argument('path') ?? getenv('SOCKET_PATH'))
            ->setPort($this->argument('port') ?? getenv('SOCKET_PORT'));
        $socket = $this->argument('domain') === self::DOMAIN_TCP ? new Socket($config) : new UnixSocket($config);
        switch ($this->argument('type')) {
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