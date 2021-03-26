<?php


namespace Otushw\ServerAPI\Controllers;

use Otushw\Helper;
use Otushw\Queue\QueueProducerInterface;
use PDO;
use Otushw\Storage\DBConnection;
use Psr\Http\Message\ServerRequestInterface;

abstract class BaseController
{
    const REQUIRED_PARAM = ['productName', 'quantity', 'total'];

    protected PDO $pdo;
    protected QueueProducerInterface $queueProducer;

    public function __construct(QueueProducerInterface $queueProducer)
    {
        $this->pdo = DBConnection::getInstance();
        $this->queueProducer = $queueProducer;
    }

    protected function getID(ServerRequestInterface $request): ?int
    {
        return $request->getAttribute('id');
    }

    protected function getBodyParam(ServerRequestInterface $request): ?array
    {
        $data = $request->getBody()->getContents();
        if (!Helper::isJSON($data)) {
            // return null/ Exception
        }
        $data = json_decode($data, true);
        if ($this->validParam($data)) {
            // return null/ Exception
        }
        return $data;
    }

    public function validParam(array $data): bool
    {
        foreach (self::REQUIRED_PARAM as $item) {
            if (empty($data[$item])) {
                return true;
            }
        }
        return true;
    }
}