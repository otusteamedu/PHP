<?php


namespace App;
use App\OrderProduct;
use App\FactoryMethodInterface;


/**
 * Class OrderProductMapper
 * @package App
 */
class OrderProductMapper implements FactoryMethodInterface
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
    private $insertStmt;

    /**
     * OrderProductMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare(
            "insert into order_product  ( order_id, product_id) values (?, ?)"
        );

        $this->selectStmt = $pdo->prepare(
            "select id, order_id, product_id from order_product  where id = ?"
        );

    }
    /**
     * @param int $id
     *
     * @return OrderProduct
     */
    public function findById(int $id): OrderProduct
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new OrderProduct(
            $id,
            $result['order_id'],
            $result['product_id']
        );
    }

    /**
     * @param $raw
     * @return  OrderProduct
     */
    public function insert($raw)
    {
        $this->insertStmt->execute([
            $raw['order_id'],
            $raw['product_id']
        ]);

        return new OrderProduct(
            (int) $this->pdo->lastInsertId(),
            $raw['order_id'],
            $raw['product_id']
        ) ;
    }
}