<?php

declare(strict_types=1);

namespace App\ReadModel\Request;

use App\Framework\Database\QueryBuilder;
use App\Model\Request\Entity\Id;
use App\Model\Request\Entity\Statuses;
use Exception;

class RequestFetcher
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
    public function getStatus(Id $id): array
    {
        $data = $this->queryBuilder
            ->table(self::TABLE_NAME)
            ->select(['status'])
            ->andWhere(['id' => $id->getValue()])
            ->fetch();

        if ($data) {
            $data['status_name'] = Statuses::getName($data['status']);
        }

        return ($data ?? []);
    }
}