<?php

declare(strict_types=1);

namespace App\Model\Product\Service;

use App\Config\Configuration;
use App\DIContainer\ContainerInterface;
use App\Model\Product\Entity\Product\Observer\ObserverInterface;
use App\Model\Product\Entity\Product\ProductInterface;

class ProductObserversRegistrar
{
    private Configuration      $config;
    private ContainerInterface $container;

    public function __construct(Configuration $config, ContainerInterface $container)
    {
        $this->config = $config;
        $this->container = $container;
    }

    public function register(ProductInterface $product): void
    {
        $observerClassNames = $this->config->getParam('productObservers');

        if (is_array($observerClassNames)) {
            foreach ($observerClassNames as $observerClassName) {
                /* @var ObserverInterface $observer */
                $observer = $this->container->get($observerClassName);

                $product->addObserver($observer, $observer->getEventName());
            }
        }
    }
}