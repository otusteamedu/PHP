<?php

namespace Test\integration\App\Controller;

use App\Controller\BillingController;
use App\Repository\OrderRepository;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Laminas\Diactoros\ServerRequest;
use PHPUnit\Framework\TestCase;

class BillingControllerTest extends TestCase
{
    /** @var \Psr\Container\ContainerInterface */
    private $container;

    protected function setUp(): void
    {
        parent::setUp();

        chdir(dirname(__DIR__, 4));
        require_once 'vendor/autoload.php';

        $this->container = require_once 'config/container.php';

        $loader = new Loader();
        $loader->loadFromDirectory($this->container->get('config')['fixture']['dir']);

        $executor = new ORMExecutor($this->container->get(EntityManagerInterface::class), new ORMPurger());
        $executor->execute($loader->getFixtures());
    }

    public function testSucceed()
    {
        /** @var \App\Controller\BillingController $controller */
        $controller = $this->container->get(BillingController::class);

        $request = new ServerRequest();
        $request = $request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => '1234567890123456',
            'sum' => '100,15',
        ]);

        $response = $controller->payAction($request);
        $body = json_decode($response->getBody()->getContents(), true);

        self::assertSame(200, $response->getStatusCode(), 'Status code should be 200');
        self::assertArrayHasKey('is_succeed', $body, 'Body should be consist field is is_succeed');
        self::assertTrue($body['is_succeed'], 'Field is is_succeed should be value is true');
    }

    public function testOrderNotFound()
    {
        /** @var \App\Controller\BillingController $controller */
        $controller = $this->container->get(BillingController::class);

        $request = new ServerRequest();
        $request = $request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => $orderNumber = '1234567890123450',
            'sum' => '100,15',
        ]);

        $response = $controller->payAction($request);
        $body = json_decode($response->getBody()->getContents(), true);
        $errors = $body['errors'];

        self::assertSame(400, $response->getStatusCode(), 'Status code should be 200');
        self::assertArrayHasKey('is_succeed', $body, 'Body should be consist field is is_succeed');
        self::assertFalse($body['is_succeed'], 'Field is is_succeed should be value is false');
        self::assertSame("Order #{$orderNumber} not found.", $errors['service'][0]);
    }

    public function testWrongSum()
    {
        /** @var \App\Controller\BillingController $controller */
        $controller = $this->container->get(BillingController::class);

        $request = new ServerRequest();
        $request = $request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => $orderNumber = '1234567890123456',
            'sum' => '100,20',
        ]);

        $response = $controller->payAction($request);
        $body = json_decode($response->getBody()->getContents(), true);
        $errors = $body['errors'];

        self::assertSame(400, $response->getStatusCode(), 'Status code should be 200');
        self::assertArrayHasKey('is_succeed', $body, 'Body should be consist field is is_succeed');
        self::assertFalse($body['is_succeed'], 'Field is is_succeed should be value is false');
        self::assertSame("Order #{$orderNumber} - sum is not match.", $errors['service'][0]);
    }

    public function testSetStatusPaid()
    {
        /** @var \App\Controller\BillingController $controller */
        $controller = $this->container->get(BillingController::class);

        $request = new ServerRequest();
        $request = $request->withParsedBody([
            'card_number' => '1234567890123456',
            'card_holder' => 'SMITH JONE',
            'card_expiration' => '01/23',
            'cvv' => '676',
            'order_number' => $orderNumber = '1234567890123456',
            'sum' => '100,15',
        ]);

        $controller->payAction($request);

        /** @var \App\Repository\OrderRepository $repository */
        $repository = $this->container->get(OrderRepository::class);
        $order = $repository->findByOrderNumber($orderNumber);

        self::assertTrue($order->getIsPaid(), 'Order status should set is true');
    }
}
