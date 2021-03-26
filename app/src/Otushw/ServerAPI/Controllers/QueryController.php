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
        $this->publish($data);
        return JsonResponse::create(['id_query' => $id]);
    }

    public function delete(ServerRequestInterface $request): JsonResponse
    {
        $orderID = $this->getID($request);
        $id = $this->createQuery();
        $data = [
            'id_query' => $id,
            'command' => 'delete',
            'data' => ['id' => $orderID]
        ];
        $this->publish($data);
        return JsonResponse::create(['id_query' => $id]);
    }

    public function update(ServerRequestInterface $request): JsonResponse
    {
        $data = $this->getBodyParam($request);
        $data['id'] = $this->getID($request);
        $id = $this->createQuery();
        $data = [
            'id_query' => $id,
            'command' => 'update',
            'data' => $data
        ];
        $this->publish($data);
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

    private function publish(array $data): void
    {
        $this->queueProducer->publish(json_encode($data));
    }
}