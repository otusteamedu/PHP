<?php

declare(strict_types=1);

namespace App\Model\Request\Repository;

use App\Framework\Database\QueryBuilder;
use App\Model\Request\Entity\Id;
use App\Model\Request\Entity\Request;
use App\Model\Request\Exception\RequestNotFoundException;
use DateTimeImmutable;
use Exception;

class PostgresqlRequestRepository implements RequestRepositoryInterface
{
    private const TABLE_NAME = 'requests';

    private QueryBuilder $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @throws Exception
     */
    public function getOne(Id $id): Request
    {
        $data = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->select(['*'])
            ->andWhere(['id' => $id->getValue()])
            ->fetch();

        if (!$data) {
            throw new RequestNotFoundException('Запрос не найден');
        }

        return $this->buildRequest($data);
    }

    /**
     * @throws Exception
     */
    public function add(Request $request): void
    {
        $data = $request->toArray();

        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->insert($data)
            ->execute();
    }

    /**
     * @throws Exception
     */
    public function update(Request $request): void
    {
        $data = $request->toArray();

        $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->update($data)
            ->andWhere(['id' => $request->getId()->getValue()])
            ->execute();
    }

    /**
     * @throws Exception
     */
    private function buildRequest(array $data): Request
    {
        return new Request(new Id($data['id']), $data['name'], new DateTimeImmutable($data['creation_date']));
    }
}