<?php


namespace App\Shop;


use App\Shop\Factory\Interfaces\FastFoodItem;

class Order
{
    public const STATUSES = [
        'NEW'       => 'new',
        'PREPARING' => 'preparing',
        'COOKED'    => 'cooked'
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
    }

    private function getNextId()
    {
        return count(self::$orders) + 1;
    }

    public function cook(): string
    {
        $this->status = self::STATUSES['COOKED'];
        return $this->item->cook();
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