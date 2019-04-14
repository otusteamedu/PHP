<?php

namespace crazydope\socket\tests;

use crazydope\socket\SocketClientInterface;
use crazydope\socket\SocketException;
use crazydope\socket\SocketFactory;
use crazydope\socket\SocketFactoryInterface;
use crazydope\socket\SocketServerInterface;
use PHPUnit\Framework\TestCase;

class SocketFactoryTest extends TestCase
{
    /**
     * @var SocketFactory
     */
    protected $socketFactory;

    protected function setUp()
    {
        $this->socketFactory = new SocketFactory();
    }

    protected function tearDown()
    {
        $this->socketFactory = null;
    }

    public function testSupportsUnixSocket(): void
    {
        $unix = defined('AF_UNIX');
        if (!$unix) {
            $this->markTestSkipped('This system does not seem to support UNIX sockets');
        }

        $this->assertTrue($unix);
    }

    public function testConstructorWorks(): void
    {
        $this->assertInstanceOf(SocketFactoryInterface::class, $this->socketFactory);
    }

    public function testInvalidType(): void
    {
        try {
            $this->socketFactory->setType(0)->createFromString('tcp://127.0.0.1:1337');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Invalid type given.', $e->getMessage());
        }

    }

    public function testInvalidScheme(): void
    {
        try {
            $this->socketFactory->createFromString('127.0.0.1');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Invalid scheme given.', $e->getMessage());
        }

    }

    public function testInvalidSchemeNotSupport(): void
    {
        try {
            $this->socketFactory->createFromString('udp://127.0.0.1:53');
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Scheme not supported.', $e->getMessage());
        }

    }

    public function testCreateServerTcp(): void
    {
        $socket = $this->socketFactory->createFromString('tcp://127.0.0.1:1337');
        $this->assertInstanceOf(SocketServerInterface::class, $socket);
    }

    public function testCreateClientTcp(): void
    {
        $socket = $this->socketFactory->setType(SocketFactory::CLIENT)->createFromString('tcp://google.com:80');
        $this->assertInstanceOf(SocketClientInterface::class, $socket);
    }

    public function testCreateClientTcpUnboundFails(): void
    {
        try {
            $this->socketFactory->setType(SocketFactory::CLIENT)->createFromString('tcp://localhost:2');
        } catch (SocketException $e) {
            $this->assertEquals('Connection refused (SOCKET_ECONNREFUSED)', $e->getMessage());
        }
    }

    /**
     * @depends testSupportsUnixSocket
     */
    public function testCreateServerUnix(): void
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'test-' . md5(microtime(true)) . '.sock';
        $socket = $this->socketFactory->createFromString('unix://' . $path);
        $this->assertInstanceOf(SocketServerInterface::class, $socket);
        $this->assertTrue(unlink($path), 'Unable to remove temporary socket ' . $path);
    }
}