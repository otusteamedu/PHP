<?php


namespace Otushw\ServerAPI\Controllers;

use Otushw\DTOs\QueryDTO;
use Otushw\Models\Query;
use Otushw\Queue\QueueProducerInterface;
use Otushw\Storage\Query\QueryMapper;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class QueryController extends BaseController
{
    private QueryMapper $queryMapper;

    public function __construct(QueueProducerInterface $queueProducer)
    {
        parent::__construct($queueProducer);
        $this->queryMapper = new QueryMapper($this->pdo);
    }

    public function create(ServerRequestInterface $request): JsonResponse
    {
        $data = $this->getBodyParam($request);
        $id = $this->createQuery();
        $data = [
            'id_query' => $id,
            'command' => 'create',
            'data' => $data
        ];
        $this->queueProducer->publish(json_encode($data));
        return JsonResponse::create(['id_query' => $id]);
    }

    public function delete(ServerRequestInterface $request): JsonResponse
    {
        $orderID = $this->getID($request);
        $id = $this->createQuery();
        $data = [
            'id_query' => $id,
            'command' => 'delete',
            'data' => ['orderID' => $orderID]
        ];
        $this->queueProducer->publish(json_encode($data));
        return JsonResponse::create(['id_query' => $id]);
    }

    public function update(ServerRequestInterface $request): JsonResponse
    {
        $data = $this->getBodyParam($request);
        $data['orderID'] = $this->getID($request);
        $id = $this->createQuery();
        $data = [
            'id_query' => $id,
            'command' => 'update',
            'data' => $data
        ];
        $this->queueProducer->publish(json_encode($data));
        return JsonResponse::create(['id_query' => $id]);
    }

    private function createQuery(): int
    {
        $queryRaw = new QueryDTO(1, Query::STATUS_BEGIN);

        $query = $this->queryMapper->insert($queryRaw);
        if (empty($query)) {
            // return Excetption
        }
        return $query->getId();
    }
}