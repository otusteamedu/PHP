<?php


namespace App\Tests\Socket;


use App\Socket\Exceptions\CanNotCreateSocketException;
use App\Socket\Socket;

class SocketTest extends \PHPUnit\Framework\TestCase
{
    private string $socketFile = '/var/run/socket.sock';

    public function testCanCreateSocketClass()
    {

        $this->expectException(\ArgumentCountError::class);
        new Socket();

        $this->expectException(CanNotCreateSocketException::class);
        new Socket('/mydir/sock');


        $socket = new Socket($this->socketFile);
        $this->assertInstanceOf(Socket::class, $socket);
    }
}
