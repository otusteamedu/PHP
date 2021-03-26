<?php


namespace Otushw\ServerAPI\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Otushw\Storage\DBConnection;
use Otushw\Storage\OrderMapper;
use PDO;

class OrderController extends AbstractController
{
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
        $params = $request->getQueryParams();
        var_dump($params);
        $orders = $this->orderMapper->getBatch();
    }

    public function show(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
    }

    public function create(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
    }

    public function delete(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
    }

    public function update(ServerRequestInterface $request)
    {
        var_dump(__METHOD__);
    }
}