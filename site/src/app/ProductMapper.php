<?php


namespace App;
use App\Product;
use App\ProductFinalPrice;
use App\FactoryMethodInterface;
use App\FinalPriceInterface;

/**
 * Class ProductMapper
 * @package App
 */
class ProductMapper implements  FactoryMethodInterface,FinalPriceInterface
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
    private $selectJoinDiscointProduct;

    /**
     * ProductMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectJoinDiscointProduct=$pdo->prepare(
            "select product.id as product_id,  product.price - discount_product.discount_product_rub * discount_product.discount_product_coefficient as products_price  from product INNER JOIN 
         discount_product ON product.discount_product_id= public.discount_product.id where  product.id = ?"
        );

        $this->selectStmt = $pdo->prepare(
            "select id, name_product,order_id, discount_product_id, price from product where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return Product
     */
    public function findById(int $id): Product
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Product(
            $id,
            $result['name_product'],
            $result['order_id'],
            $result['discount_product_id'],
            $result['price']
        );
    }

    /**
     * @param int $id
     * @return \App\ProductFinalPrice|mixed
     */
    public function findByPriceId(int $id)
    {

        $this->selectJoinDiscointProduct->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectJoinDiscointProduct->execute([$id]);
        $result=$this->selectJoinDiscointProduct->fetch();
        return new ProductFinalPrice(
            $result['product_id'],
            $result['products_price']
        );


    }
}