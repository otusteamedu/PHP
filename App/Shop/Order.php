<?php


namespace App\Shop;


use App\Shop\Factory\Interfaces\FastFoodItem;
use App\Shop\Observers\OrderObserver;

class Order
{
    public const STATUSES = [
        'NEW'       => 'new',
        'PREPARING' => 'preparing',
        'COOKED'    => 'cooked'
    ];

    public const EVENTS = [
        'STATUS_UPDATE' => 'order:status.update'
    ];

    private static array $orders = [];

    private FastFoodItem $item;
    private int $id;
    private string $status;

    public function __construct(FastFoodItem $item)
    {
        $this->item = $item;
        $this->id = $this->getNextId();
        $this->status = self::STATUSES['NEW'];
        self::$orders[$this->id] = $this;
        $this->notifyOnStatus();
    }

    private function getNextId()
    {
        return count(self::$orders) + 1;
    }

    public function prepare(): void
    {
        if ($this->status === self::STATUSES['NEW']) {
            $this->status = self::STATUSES['PREPARING'];
            $this->notifyOnStatus();
        }
    }

    public function cook(): string
    {
        if ($this->status !== self::STATUSES['COOKED']) {
            $this->prepare();
            $this->status = self::STATUSES['COOKED'];
            $this->notifyOnStatus();
        }
        return $this->item->cook();
    }

    private function notifyOnStatus()
    {
        OrderObserver::getInstance()->notify(self::EVENTS['STATUS_UPDATE'], [
            'id'     => $this->getId(),
            'status' => $this->status
        ]);
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    public static function get(int $id): ?Order
    {
        return self::$orders[$id];
    }

    /**
     * @return Order[]
     */
    public static function getAll(): array
    {
        return self::$orders;
    }


}