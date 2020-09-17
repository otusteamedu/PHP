<?php
declare(strict_types = 1);

namespace module;

require "vendor/autoload.php";

use PHPUnit\Framework\TestCase;
use \Models\Orders\Order;
use Models\Orders\OrdersMapper;
use Controllers\DataBaseControllers\PostgresConnection;
use PDO;

class OrderTestCase extends TestCase
{
    private $order;
    private $connection;
    private $mapper;

    public function setUp(): void
    {
        $this->order = new Order(null, 5700, );
        $postgres = new PostgresConnection();
        $this->connection = new PDO($postgres->connectionString());
        $this->mapper = new OrdersMapper($this->connection);
        $this->order = $this->mapper->setOrder($this->order);

    }

    public function tearDown(): void
    {
        $orderID = $this->order->getId();
        $this->mapper->delete($orderID);
    }

    /**
     * ПРоверка добавления заказа в БД
     * @return void
     */
    public function testOrderStore(): void
    {
        $result = $this->mapper->setOrderIsPaid($this->order);
        static::assertTrue($result);
    }

}