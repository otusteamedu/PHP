<?php


namespace Otushw\ServerAPI\Controllers;

use Otushw\Queue\QueueFactory;
use Otushw\Queue\QueueProducerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Otushw\Storage\Order\OrderMapper;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderController extends BaseController
{

    private OrderMapper $orderMapper;

    public function __construct(QueueProducerInterface $queueProducer)
    {
        parent::__construct($queueProducer);
        $this->orderMapper = new OrderMapper($this->pdo);
    }

    public function index(ServerRequestInterface $request): JsonResponse
    {
        $limit = 5;
        $offset = 0;
        $params = $request->getQueryParams();
        if (!empty($params['limit'])) {
            $limit = $params['limit'];
        }
        if (!empty($params['offset'])) {
            $offset = $params['offset'];
        }
        $orders = $this->orderMapper->getBatch($limit, $offset);
        return JsonResponse::create($orders->toArray());
    }

    public function show(ServerRequestInterface $request): JsonResponse
    {
        $id = $this->getID($request);
        $order = $this->orderMapper->findById($id);
        return JsonResponse::create([
            'id' => $order->getId(),
            'productName' => $order->getProductName(),
            'quantity' => $order->getQuantity(),
            'total' => $order->getTotal(),
        ]);
    }

}