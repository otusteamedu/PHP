<?php

namespace App\EntityRepository;

use App\Entity\Order;
use App\Entity\OrderContents;
use PDO;
use PDOStatement;

class OrderContentsRepository
{
    private PDOStatement $updProductsSt;
    private PDOStatement $updDeliveriesSt;
    private PDOStatement $updDiscountsSt;
    private PDOStatement $dropStProducts;
    private PDOStatement $dropStDeliveries;
    private PDOStatement $dropStDiscounts;

    /**
     * OrderContentsRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->dropStProducts = $pdo->prepare(
            'delete from products_orders_rel where order_id = ?;'
        );
        $this->dropStDeliveries = $pdo->prepare(
            'delete from products_orders_rel where order_id = ?;'
        );
        $this->dropStDiscounts = $pdo->prepare(
            'delete from products_orders_rel where order_id = ?;'
        );
        $this->updProductsSt = $pdo->prepare(
            'insert into products_orders_rel(order_id, product_id)  values (?, ?);'
        );
        $this->updDeliveriesSt = $pdo->prepare(
            'insert into delivery_services_orders_rel(order_id, delivery_id)  values (?, ?);'
        );
        $this->updDiscountsSt = $pdo->prepare(
            'insert into discounts_orders_rel(order_id, discount_id)  values (?, ?);'
        );
    }

    /**
     * @param Order         $order
     * @param OrderContents $contents
     */
    public function update(Order $order, OrderContents $contents): void
    {
        $this->dropStProducts->execute([$order->getId()]);
        $this->dropStDeliveries->execute([$order->getId()]);
        $this->dropStDiscounts->execute([$order->getId()]);

        foreach ($contents->getProducts() as $product) {
            $this->updProductsSt->execute([$order->getId(), $product->getId()]);
        }
        foreach ($contents->getDeliveryServices() as $service) {
            $this->updDeliveriesSt->execute(
                [$order->getId(), $service->getId()]
            );
        }
        foreach ($contents->getDiscounts() as $discount) {
            $this->updDiscountsSt->execute(
                [$order->getId(), $discount->getId()]
            );
        }
    }
}