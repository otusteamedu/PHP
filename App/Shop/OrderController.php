<?php


namespace App\Shop;


use App\Container;
use App\Shop\Factory\Interfaces\FastFoodFactory;
use App\Shop\Factory\Interfaces\FastFoodItem;
use Exception;

class OrderController
{
    /**
     * @param string $url
     * @param array $data
     * @return int
     * @throws Exception
     */
    public function post(array $data): int
    {
        $order = new Order($this->resolveProduct($data));
        return $order->getId();
    }

    /**
     * @param $data
     * @return FastFoodItem
     * @throws Exception
     */
    private function resolveProduct($data): FastFoodItem
    {
        try {
            $food = Container::make('food', $data);
            if ($food instanceof FastFoodItem) {
                array_walk($data['ingredients'], fn($i) => $food->ingredients()->add($i));
                return $food;
            }
            throw new Exception(sprintf('Can not make %s food', $data['type']));
        } catch (Exception $e) {
            throw new Exception(sprintf('Factory for %s food does not exist', $data['food']));
        }
    }
}