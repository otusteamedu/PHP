<?php

namespace crazydope\socket\tests;

use crazydope\socket\SocketClientInterface;
use crazydope\socket\SocketFactory;
use PHPUnit\Framework\TestCase;

class SocketTest extends TestCase
{
    public function testConnectGoogle(): void
    {
        $socket = (new SocketFactory())->createClient('tcp://www.google.com:80');
        $this->assertInstanceOf(SocketClientInterface::class, $socket);
        $this->assertEquals('resource', gettype($socket->getResource()));

        $data = "GET / HTTP/1.1\r\nHost: www.google.com\r\n\r\n";
        $this->assertEquals(strlen($data), $socket->write($data));

        // read just 4 bytes
        $this->assertEquals('HTTP', $socket->read(4));
    }
}