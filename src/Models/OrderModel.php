<?php

namespace App\Models;

use App\Core\Delivery\AdapterDelivery\DeliverServiceAdapter;
use App\Core\RenderObserver\Observable;
use App\Core\Users\UsersFactory\UserFactoryInterface;

class OrderModel extends BaseModel
{
    private UserFactoryInterface $user;
    private string $dateCreate;
    private string $isPayed;
    private array $products;

    /**
     * OrderModel constructor.
     * @param UserFactoryInterface $user
     * @param string $dateCreate
     * @param string $isPayed
     * @param array $products
     */
    public function __construct(UserFactoryInterface $user, array $products)
    {
        parent::__construct();
        $this->user = $user;
        $this->dateCreate = time();
        $this->isPayed = false;
        $this->products = $products;
    }


    public function calculateDeliverPrice(DeliverServiceAdapter $deliverService): float
    {
        $deliverPrice = 0.0;
        foreach ($this->products as $product) {
            $deliverPrice += $deliverService->calculateDeliverPrice($product);
        }
        return $deliverPrice;
    }

    /**
     * @return UserFactoryInterface
     */
    public function getUser(): UserFactoryInterface
    {
        return $this->user;
    }

    /**
     * @return int|string
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @return false|string
     */
    public function getIsPayed()
    {
        return $this->isPayed;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    public function update(Observable $object): void
    {
        //..
    }
}