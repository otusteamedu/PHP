<?php
declare(strict_types=1);

namespace CodeArchitecture\After\Repositories;

use PDO;
use CodeArchitecture\After\Query\SelectQueryBuilder;

class OrderPDORepository implements RepositoryInterface
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * OrderPDORepository constructor.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $orderNumber
     * @param string $dateFrom
     * @param string $dateBetween
     * @param int $limit
     *
     * @return mixed
     */
    public function getOrdersBrief(string $orderNumber, string $dateFrom, string $dateBetween, int $limit = 100): mixed
    {
        $query = (new SelectQueryBuilder())
            ->select(
                'id',
                'orderNumber',
                'orderState',
                'paymentState',
                'shippingState',
                'DATE_FORMAT(\'created_at\', \'%d.%m.%Y %H:%i:%s\') AS \'created\''
            )
            ->from('order_history')
            ->where('orderNumber = :orderNumber')
            ->between('created_at BETWEEN :dateFrom AND :dateBetween')
            ->limit()
            ->createQuery();

        $pdoStatement = $this->pdo->prepare($query);
        $pdoStatement->execute([
                'orderNumber' => $orderNumber,
                'dateFrom' => $dateFrom,
                'dateBetween' => $dateBetween,
                'limit' => $limit
            ]
        );

        return $pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
