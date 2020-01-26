<?php


namespace App;
use App\DeliveryService;
use App\DeliveryServiceFinalPrice;
use App\FactoryMethodInterface;
use App\FinalPriceInterface;

/**
 * Class DeliverServiceMapper
 * @package App
 */
class DeliverServiceMapper implements FactoryMethodInterface,FinalPriceInterface
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
     * @var bool|\PDOStatement
     */
    private $selectJoinDiscoint;

    /**
     * DeliverServiceMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectJoinDiscoint = $pdo->prepare(
            "select delivery_service.id as delivery_service_id,  delivery_service.price - discount_delivery_service.discount_delivery_service_rub * discount_delivery_service.discount_delivery_service_coefficient as delivery_price  from delivery_service  INNER JOIN 
            discount_delivery_service ON  delivery_service.discount_delivery_service_id=discount_delivery_service.id where  delivery_service.id = ?"
        );

        $this->selectStmt = $pdo->prepare(
            "select id, name_delivery_service, discount_delivery_service_id, price from delivery_service where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return DeliveryService
     */
    public function findById(int $id): DeliveryService
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new DeliveryService(
            $id,
            $result['name_delivery_service'],
            $result['discount_delivery_service_id'],
            $result['price']
        );
    }

    /**
     * @param int $id
     * @return \App\DeliveryServiceFinalPrice
     */
    public function findByPriceId(int $id)
    {
        $this->selectJoinDiscoint->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectJoinDiscoint->execute([$id]);
        $result = $this->selectJoinDiscoint->fetch();
        return new DeliveryServiceFinalPrice(
            $result['delivery_service_id'],
            $result['delivery_price']
        );

    }
}