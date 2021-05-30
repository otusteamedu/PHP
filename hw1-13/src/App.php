<?php
namespace Src;

use Src\Services\RestaurantService;
use Src\Strategy\CookingStrategy;

class App
{
    /**
     * @throws \Exception
     */
    public function run($order): void
    {
        if (!empty($order)) {
            $restaurantService = new RestaurantService(new CookingStrategy($order));
            $restaurantService->prepareOrder();
        } else {
            throw new \Exception('Please, choose the dish you want' . PHP_EOL);
        }
    }
}