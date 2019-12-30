<?php


namespace App;
use App\DiscountDeliveryService;
use App\FactoryMethodInterface;

/**
 * Class DiscountDeliveryServiceMapper
 * @package App
 */
class DiscountDeliveryServiceMapper implements FactoryMethodInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool|\PDOStatement
     */
    private $selectStmt;

    /**
     * DiscountDeliveryServiceMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;


        $this->selectStmt = $pdo->prepare(
            "select id, discount_delivery_service_rub, discount_delivery_service_coefficient from discount_delivery_service where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return DiscountDeliveryService
     */
    public function findById(int $id): DiscountDeliveryService
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new DiscountDeliveryService(
            $id,
            $result['discount_delivery_service_rub'],
            $result['discount_delivery_service_coefficient']
        );
    }
}