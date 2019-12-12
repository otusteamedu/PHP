<?php


namespace App;
use App\Product;
use App\ProductFinalPrice;
use App\FactoryMethodInterface;
use App\FinalPriceInterface;
class ProductMapper implements  FactoryMethodInterface,FinalPriceInterface
{
    private $pdo;

    private $selectStmt;
    private $selectJoinDiscointProduct;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectJoinDiscointProduct=$pdo->prepare(
            "select product.id as productId,  product.price - discount_product.discount_product_rub * discount_product.discount_product_coefficient as productsPrice  from product INNER JOIN 
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

    public function findByPriceId(int $id)
    {

        $this->selectJoinDiscointProduct->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectJoinDiscointProduct->execute([$id]);
        $result=$this->selectJoinDiscointProduct->fetch();
        return new ProductFinalPrice(
            $result['productId'],
            $result['productsPrice']
        );


    }
}