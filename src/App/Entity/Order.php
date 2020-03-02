<?php

namespace App\Entity;

use App\EntityFilter\IEntityFilter;
use App\EntityFilter\OrderFilter;
use App\EntityInterface\IDiscount;
use App\EntityInterface\IEntity;
use App\EntityInterface\IFetchAssoc;
use App\EntityInterface\IOrder;
use App\EntityInterface\IProduct;
use App\EntityRepository\OrderRepository;
use PDO;

class Order extends CommonEntity implements IOrder, IFetchAssoc
{
    public const STATE_NEW = 0;
    public const STATE_SENT = 1;
    public const STATE_REVERTED = -1;

    private int $state;
    private Client $client;
    private string $dtCreated;
    private OrderContents $contents;
    private OrderCalculator $calculator;

    /**
     * Order constructor.
     * @param PDO    $pdo
     * @param Client $client
     */
    public function __construct(PDO $pdo, Client $client)
    {
        $this->client = $client;
        $this->state = self::STATE_NEW;
        $this->dtCreated = date('Y-m-d H:i:s');
        $this->repository = new OrderRepository($pdo);
        $this->contents = new OrderContents($pdo);
        $this->calculator = new OrderCalculator($this->contents);
    }

    /**
     * @param PDO                       $pdo
     * @param IEntityFilter|OrderFilter $filter
     * @return array
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array {
        return OrderRepository::getEntitiesByFilter($pdo, $filter);
    }

    /**
     * @param PDO $pdo
     * @param int $id
     * @return Order
     */
    public static function getById(PDO $pdo, int $id): IEntity
    {
        return self::getEntitiesByFilter($pdo, new OrderFilter($id))[0] ??
               new Order($pdo, new Client($pdo));
    }

    /**
     * @return array
     */
    public function fetchToAssoc(): array
    {
        return [
            'state'        => $this->state,
            'client'       => $this->client->fetchToAssoc(),
            'contents'     => $this->contents->fetchToAssoc(),
            'date_created' => $this->dtCreated,
            'total_price'  => $this->getTotalPrice(),
        ];
    }

    /**
     * @param IProduct $product
     * @return Order
     */
    public function addProduct(IProduct $product): IOrder
    {
        $this->contents->addProduct($product);
        return $this;
    }

    /**
     * @param IDiscount $discount
     * @return Order
     */
    public function addDiscount(IDiscount $discount): IOrder
    {
        $this->contents->addDiscount($discount);
        return $this;
    }

    /**
     * @param DeliveryService $service
     * @return Order
     */
    public function addDeliveryService(DeliveryService $service): IOrder
    {
        $this->contents->addDeliveryService($service);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getTotalPrice(): float
    {
        return $this->calculator->getTotalPrice();
    }

    /**
     * @return OrderContents
     */
    public function getContents(): OrderContents
    {
        return $this->contents;
    }

    /**
     * @inheritDoc
     */
    public function send(): IOrder
    {
        $this->state = self::STATE_SENT;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function revert(): IOrder
    {
        $this->state = self::STATE_REVERTED;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function isB2C(): bool
    {
        return $this->client instanceof PrivateClient;
    }

    /**
     * @inheritDoc
     */
    public function isB2B(): bool
    {
        return $this->client instanceof CorporateClient;
    }

    /**
     * @return int
     */
    public function getState(): int
    {
        return $this->state;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     * @return Order
     */
    public function setClient(Client $client): Order
    {
        $this->client = $client;
        return $this;
    }

    /**
     * @return string
     */
    public function getDtCreated(): string
    {
        return $this->dtCreated;
    }

    /**
     * @param int $state
     * @return Order
     */
    public function setState(int $state): Order
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @param string $dtCreated
     * @return Order
     */
    public function setDtCreated(string $dtCreated): Order
    {
        $this->dtCreated = $dtCreated;
        return $this;
    }
}