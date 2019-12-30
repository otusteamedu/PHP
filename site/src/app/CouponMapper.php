<?php


namespace App;
use App\Coupon;
use App\FactoryMethodInterface;

/**
 * Class CouponMapper
 * @package App
 */
class CouponMapper implements FactoryMethodInterface
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
     * CouponMapper constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;


        $this->selectStmt = $pdo->prepare(
            "select id, discount_coupon_rub, discount_coupon_coefficient from coupon where id = ?"
        );

    }

    /**
     * @param int $id
     *
     * @return Coupon
     */
    public function findById(int $id): Coupon
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return new Coupon(
            $id,
            $result['discount_coupon_rub'],
            $result['discount_coupon_coefficient']
        );
    }
}