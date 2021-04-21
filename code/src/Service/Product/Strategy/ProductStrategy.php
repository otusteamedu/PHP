<?php


namespace App\Service\Product\Strategy;


use App\Entity\Burger;
use App\Entity\HotDog;
use App\Entity\Sandwich;
use App\Service\Product\Factory\BurgerFactory;
use App\Service\Product\Factory\HotDogFactory;
use App\Service\Product\Factory\ProductFactoryInterface;
use App\Service\Product\Factory\SandwichFactory;
use http\Exception\InvalidArgumentException;
use Psr\Container\ContainerInterface;

class ProductStrategy implements ProductStrategyInterface
{
    private ContainerInterface $container;

    /**
     * ProductStrategy constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param string $productType
     * @return \App\Service\Product\Factory\ProductFactoryInterface
     */
    public function getFactory(string $productType): ProductFactoryInterface
    {
        switch ($productType) {
            case Burger::TYPE:
                return $this->container->get(BurgerFactory::class);
            case HotDog::TYPE:
                return $this->container->get(HotDogFactory::class);
            case Sandwich::TYPE:
                return $this->container->get(SandwichFactory::class);
            default:
                throw new InvalidArgumentException();
        }
    }
}
