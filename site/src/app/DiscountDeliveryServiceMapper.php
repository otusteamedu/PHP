<?php


namespace App;
use App\DiscountDeliveryService;
use App\FactoryMethodInterface;
class DiscountDeliveryServiceMapper implements FactoryMethodInterface
{
    private $pdo;

    private $selectStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;


        $this->selectStmt = $pdo->prepare(
            "select id, discount_product_rub, discount_product_coefficient from discount_delivery_service where id = ?"
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
            $result['discount_product_rub'],
            $result['discount_product_coefficient']
        );
    }
}