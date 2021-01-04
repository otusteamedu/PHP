<?php

namespace App\Model;

use App\Api\LoggerInterface;
use Socket\Raw\Socket;

class ServerHandler
{
    private UsersStorage $storage;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(UsersStorage $storage, LoggerInterface $logger)
    {
        $this->storage = $storage;
        $this->logger = $logger;
    }

    public function run(Socket $socket)
    {
        while ($c = $socket->accept()) {
            $c->write('Hello');
            $this->logger->writeln('Client connected '.$c->getSockName());
            $request = $c->read(2048);
            [$cmd, $params] = explode(' ', $request);
            $this->logger->writeln('Command '.$request);
            switch ($cmd) {
                case 'user.list':
                    $this->userList($c);
                    break;
                case 'user.add':
                    $this->userAdd($c, $params);
                    break;
                default:
                    $c->write("Command {$cmd} is not found. Use: user.list, user.add [user]");
            }
            $c->close();
        }
    }

    private function userList(Socket $socket)
    {
        $socket->write($this->storage->get('users'));
    }

    private function userAdd(Socket $socket, string $newUser)
    {
        $this->storage->addUser($newUser);
        $socket->write('Ok');
    }
}