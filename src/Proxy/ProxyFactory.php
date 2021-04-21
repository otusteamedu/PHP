<?php


namespace Src\Proxy;


use Src\AbstractFactory\AbstractFood;
use Src\AbstractFactory\FoodFactory;

class ProxyFactory implements FoodFactory
{
    private FoodFactory $realSubject;

    public function __construct(FoodFactory $realSubject)
    {
        $this->realSubject = $realSubject;
    }

    public function cookFood(): AbstractFood
    {
        if (readline('Are you confirm the order? yes/no ') === 'yes') {
            return $this->realSubject->cookFood();
        } else {
            throw new \Exception('Ok, the order is canceled.');
        }
    }
}