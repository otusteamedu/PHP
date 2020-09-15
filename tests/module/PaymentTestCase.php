<?php
declare(strict_types = 1);

namespace module;

require "vendor/autoload.php";

use Exception\CardValidatorExceptions\CurlException;
use PHPUnit\Framework\TestCase;
use Controllers\Orders\Payment;
use Source\CurlRequest;


class PaymentTestCase extends TestCase
{
//    private $order;

//    public function setUp(): void
//    {
//        $this->order = new Order(null, 5700);
//        $postgres = new PostgresConnection();
//        $connection = new \PDO($postgres->connectionString());
//        (new OrdersMapper($connection))->setOrder($this->order);
//    }
//
//    public function tearDown(): void
//    {
//        $orderID = $this->order->getId();
//        $postgres = new PostgresConnection();
//        $connection = new \PDO($postgres->connectionString());
//        (new OrdersMapper($connection))->delete($orderID);
//    }

    protected function tearDown(): void
    {
        \Mockery::close();
    }


    /**
     * ПРоверка возврата ответа 200
     * @return void
     */
    public function testPaymentSend(): void
    {

        $data = [
            'card_expiration' => '01/21',
            'card_holder' => 'Aleksei Sokolov',
            'card_number' => '1111 1111 1111 1111',
            'cvv' => 123,
            'amount' => 1234
        ];
        
        $request = \Mockery::mock(CurlRequest::class);
        $request->shouldReceive('send')->andReturn('200');
        $request->shouldReceive('setData');
        $request->shouldReceive('setUrl');

        $payment = new Payment($data, $request);
        $result = $payment->pay();

        static::assertSame('200', $result);
    }


}