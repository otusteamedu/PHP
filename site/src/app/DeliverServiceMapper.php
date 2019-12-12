<?php


namespace App;
use App\DeliveryService;
use App\DeliveryServiceFinalPrice;
use App\FactoryMethodInterface;
use App\FinalPriceInterface;
class DeliverServiceMapper implements FactoryMethodInterface,FinalPriceInterface
{
    private $pdo;

    private $selectStmt;

    private $selectJoinDiscoint;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectJoinDiscoint = $pdo->prepare(
            "select delivery_service.id as deliveryServiceId,  delivery_service.price - discount_delivery_service.discount_delivery_service_rub * discount_delivery_service.discount_delivery_service_coefficient as deliveryPrice  from delivery_service  INNER JOIN 
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
            $result['ame_delivery_service'],
            $result['discount_delivery_service_id'],
            $result['price']
        );
    }

    public function findByPriceId(int $id)
    {
        $this->selectJoinDiscoint->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectJoinDiscoint->execute([$id]);
        $result = $this->selectJoinDiscoint->fetch();
        return new DeliveryServiceFinalPrice(
            $result['deliveryServiceId'],
            $result['deliveryPrice']
        );

    }
}