<?php


namespace App\Service\Product\Preparation;


use App\Entity\ProductInterface;
use App\Service\Product\Order\ProductOrderInterface;
use Psr\Container\ContainerInterface;

class ProductPreparationProxy implements ProductPreparationInterface
{
    private ProductPreparationService $service;

    /**
     * ProductPreparationProxy constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->service = $container->get(ProductPreparationService::class);
    }


    public function process(ProductOrderInterface $order): ProductInterface
    {
        $product = $this->service->process($order);

        if (!$this->postPreparation($product)) {
            $observer = $order->getObserver();
            $order->detach($observer);

            do {
                $product = $this->service->process($order);
            } while (!$this->postPreparation($product));


            $order->attach($observer);
        }

        $order->setState($this->getGoodMessage($product));
        return $product;
    }

    private function postPreparation(ProductInterface $product): bool
    {
        return (bool)rand(0, 2);
    }

    private function getGoodMessage(ProductInterface $product): string
    {
        return sprintf(
            '%s%s готов', $product, PHP_EOL
        );
    }
}
