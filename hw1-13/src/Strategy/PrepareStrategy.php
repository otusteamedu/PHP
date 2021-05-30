<?php
namespace Src\Strategy;

use Src\AbstractFactory\AbstractFoodFactory;
use Src\Proxy\Proxy;

class PrepareStrategy implements Strategy
{
    /**
     * @throws \Exception
     */
    public function chooseDishesToCook(string $order)
    {
        $className = 'Src\AbstractFactory\\' . ucfirst($order) . 'Factory';
        if (class_exists($className) && new $className instanceof AbstractFoodFactory) {
            return new Proxy(new $className);
        }

        throw new \Exception('Sorry, this dishes is not exists in our menu' . PHP_EOL);
    }
}
