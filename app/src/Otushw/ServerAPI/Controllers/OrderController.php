<?php


namespace Otushw\ServerAPI\Controllers;

use Otushw\DTOs\OrderDTO;
use Otushw\Models\Order;
use Psr\Http\Message\ServerRequestInterface;
use Otushw\Storage\DBConnection;
use Otushw\Storage\OrderMapper;
use PDO;

class OrderController extends BaseController
{
    const REQUIRED_PARAM = ['productName', 'quantity', 'total'];

    private PDO $pdo;
    private OrderMapper $orderMapper;

    public function __construct()
    {
        $this->pdo = DBConnection::getInstance();
        $this->orderMapper = new OrderMapper($this->pdo);
    }

    public function index(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
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
        var_dump($orders);
    }

    public function show(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
        $id = $this->getID($request);
        $order = $this->orderMapper->findById($id);
        var_dump($order);
    }

    public function create(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
        $data = $this->getBodyParam($request);
        $orderRaw = new OrderDTO(1, $data['productName'], $data['quantity'], $data['total']);
        $order = $this->orderMapper->insert($orderRaw);
        var_dump($order);
    }

    public function delete(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
        $id = $this->getID($request);
        $result = $this->orderMapper->delete($id);
        var_dump($result);
    }

    public function update(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
        $id = $this->getID($request);
        $data = $this->getBodyParam($request);
        $order = new Order($id, $data['productName'], $data['quantity'], $data['total']);
        var_dump($order);
        $r = $this->orderMapper->update($order);
        var_dump($r);
    }

    private function getID(ServerRequestInterface $request): ?int
    {
        return $request->getAttribute('id');
    }

    private function getBodyParam(ServerRequestInterface $request): ?array
    {
        $data = $request->getBody()->getContents();
        if (!$this->isJSON($data)) {
            // return null
        }
        $data = json_decode($data, true);
        foreach (self::REQUIRED_PARAM as $item) {
            if (empty($data[$item])) {
//                return null
            }
        }
        return $data;
    }
}