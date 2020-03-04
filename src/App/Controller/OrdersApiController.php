<?php

namespace App\Controller;

use App\Core\AppException;
use App\Core\Bootstrap;
use App\Core\Environment;
use App\Entity\Client;
use App\Entity\DeliveryService;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\Product;
use App\Service\OrdersTaskService;
use Exception;

class OrdersApiController extends ApiController
{
    private const QUEUE_NAME = 'orders';
    private Environment $env;

    /**
     * OrdersApiController constructor.
     * @param Bootstrap $app
     */
    public function __construct(Bootstrap $app)
    {
        $this->env = new Environment();
        parent::__construct($app);
    }

    /**
     * @throws AppException
     * @throws Exception
     */
    public function pushTask()
    {
        $formDataAsJsonStr = json_encode($_POST);
        $taskService = new OrdersTaskService();
        $ticketId = $taskService->pushTask($formDataAsJsonStr, self::QUEUE_NAME);
        $this->app->getResponse()->write(
            json_encode(
                [
                    'ticketId' => $ticketId,
                ]
            )
        );
    }

    /**
     * @throws AppException
     */
    public function getOrderStatus()
    {
        $this->app->getRequest()->validateRequiredParams('ticket_id');
        $ticketId = $this->app->getRequest()->getFilter('ticket_id');
        $service = new OrdersTaskService();
        $service->checkTask($ticketId, $order);
        $this->app->getResponse()->write(json_encode($order ?? false));
    }

    public function runTasks()
    {
        try {
            $service = new OrdersTaskService();
            $service->runWorkers(self::QUEUE_NAME);
        } catch (Exception $e) {
        }
    }

    /**
     * @throws AppException
     */
    public function calculateOrder()
    {
        try {
            sleep(random_int(1, 5));
        } catch (Exception $e) {
        }
        $pdo = $this->app->getPdo();
        try {
            $client = Client::getClientByType($pdo, $_POST['client_type']);
        } catch (Exception $e) {
            throw new AppException($e->getMessage(), 400);
        }
        $client->setName($_POST['client_name'])->setAddress(
            $_POST['client_address']
        )->create();
        $order = $client->createOrder($pdo);
        foreach ($_POST['products'] as $productId) {
            $order->getContents()->addProduct(
                Product::getById($pdo, $productId)
            );
        }
        try {
            $order->getContents()->addDeliveryService(
                DeliveryService::getById($pdo, random_int(1, 3))
            );
            $order->getContents()->addDiscount(
                Discount::getById($pdo, random_int(1, 2))
            );
            $order->getContents()->update($order);
        } catch (Exception $e) {
        }
        $this->app->getResponse()->write(
            json_encode(
                Order::getById($this->app->getPdo(), $order->getId())
                     ->fetchToAssoc(),
                JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
            )
        );
        try {
            sleep(random_int(1, 5));
        } catch (Exception $e) {
        }
    }
}