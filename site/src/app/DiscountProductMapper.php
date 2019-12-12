<?php


namespace App;
use App\DiscountProduct;
use App\FactoryMethodInterface;

class DiscountProductMapper implements FactoryMethodInterface
{
    private $pdo;

    private $selectStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;


        $this->selectStmt = $pdo->prepare(
            "select id, discount_product_rub, discount_product_coefficient from discount_product where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return DiscountProduct
     */
    public function findById(int $id): DiscountProduct
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new DiscountProduct(
            $id,
            $result['discount_product_rub'],
            $result['discount_product_coefficien']
        );
    }
}