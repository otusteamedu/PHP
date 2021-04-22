<?php


namespace Src\Strategy;

use Src\AbstractFactory\FoodFactory;
use Src\Proxy\ProxyFactory;

class CookStrategy implements Strategy
{

    /**
     * @throws \Exception
     */
    public function chooseMealToCook(string $order): FoodFactory
    {
            $className = 'Src\AbstractFactory\\' . ucfirst($order) . 'Factory';
            if (class_exists($className) && new $className instanceof FoodFactory) {
                return new ProxyFactory(new $className);
            } else {
                throw new \Exception('We do not have such meal in menu' . PHP_EOL);
            }
    }
}