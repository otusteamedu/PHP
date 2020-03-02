<?php

namespace App\Entity;

use App\EntityInterface\IDeliveryService;
use App\EntityInterface\IDiscount;
use App\EntityInterface\IFetchAssoc;
use App\EntityInterface\IOrder;
use App\EntityInterface\IOrderContents;
use App\EntityInterface\IProduct;
use App\EntityRepository\OrderContentsRepository;
use PDO;

/**
 * TODO: должна быть возможность добавлять несколько одинаковых товаров
 * Class OrderContents
 * @package App\Entity
 */
class OrderContents implements IOrderContents, IFetchAssoc
{
    /**
     * @var IProduct[] $products
     */
    private array $products = [];
    /**
     * @var IDiscount[] $discounts
     */
    private array $discounts = [];
    /**
     * @var IDeliveryService[] $deliveryServices
     */
    private array $deliveryServices = [];
    /**
     * @var OrderContentsRepository $repository
     */
    private OrderContentsRepository $repository;

    /**
     * OrderContents constructor.
     * @param $pdo
     */
    public function __construct($pdo)
    {
        $this->repository = new OrderContentsRepository($pdo);
    }

    /**
     * @return array
     */
    public function fetchToAssoc(): array
    {
        return [
            'products'         => array_map(
                fn(Product $product) => $product->fetchToAssoc(),
                $this->products
            ),
            'deliveryServices' => array_map(
                fn(DeliveryService $service) => $service->fetchToAssoc(),
                $this->deliveryServices
            ),
            'discounts'        => array_map(
                fn(Discount $discount) => $discount->fetchToAssoc(),
                $this->discounts
            ),
        ];
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return Discount[]
     */
    public function getDiscounts(): array
    {
        return $this->discounts;
    }

    /**
     * @return DeliveryService[]
     */
    public function getDeliveryServices(): array
    {
        return $this->deliveryServices;
    }

    /**
     * @param IProduct $product
     * @return OrderContents
     */
    public function addProduct(IProduct $product): OrderContents
    {
        array_push($this->products, $product);
        return $this;
    }

    /**
     * @param IDiscount $discount
     * @return OrderContents
     */
    public function addDiscount(IDiscount $discount): OrderContents
    {
        array_push($this->discounts, $discount);
        return $this;
    }

    /**
     * @param IDeliveryService $service
     * @return OrderContents
     */
    public function addDeliveryService(IDeliveryService $service): OrderContents
    {
        array_push($this->deliveryServices, $service);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function update(Order $order): OrderContents
    {
        $this->repository->update($order, $this);
        return $this;
    }
}