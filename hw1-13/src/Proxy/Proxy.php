<?php
namespace Src\Proxy;

use Src\AbstractFactory\AbstractFoodFactory;
use Src\AbstractFactory\AbstractFoodInterface;

class Proxy implements AbstractFoodFactory
{
    private AbstractFoodFactory $food;

    public function __construct(AbstractFoodFactory $food)
    {
        $this->food = $food;
    }

    /**
     * @throws \Exception
     */
    public function cookFood(): AbstractFoodInterface
    {
        if (readline('Are you confirm order? yes/no ') === 'yes') {
            return $this->food->cookFood();
        }

        throw new \Exception('Order is canceled.');
    }
}