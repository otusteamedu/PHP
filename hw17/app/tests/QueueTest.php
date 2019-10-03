<?php
/**
* Tests for Queue class
* Requires installed and enabled a RabbitMQ on localhost
*
* @coversDefaultClass Jekys\Queue
*
* @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
*
*/

use PHPUnit\Framework\TestCase;
use Jekys\Queue;

final class QueueTest extends TestCase
{
    /**
     * @var Jekys\Queue
     */
    private static $queue;

    /**
     * @var array
     */
    private static $settings = [
        'host' => 'localhost',
        'port' => 5672,
        'user' => 'mq_user',
        'password' => 'mq_user_password'
    ];

    /**
     * Creates connection with RabbitMQ before test start
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$queue = new Queue(
            self::$settings['host'],
            self::$settings['port'],
            self::$settings['user'],
            self::$settings['password'],
            'test_queue_'.time()
        );
    }

    /**
     * If everything is ok method should return true
     *
     * @covers ::sendMessage
     *
     * @return void
     */
    public function testSendMessage()
    {
        $this->assertTrue(
            self::$queue->sendMessage('test')
        );
    }

    /**
     * Trying to get message sent before
     *
     * @covers ::getMessage()
     *
     * @return void
     */
    public function testGetMessage(): void
    {
        $this->assertEquals(
            'test',
            self::$queue->getMessage()
        );
    }
}
