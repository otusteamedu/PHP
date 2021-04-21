<?php


namespace App\Service\Product\Preparation;


use App\Entity\ProductInterface;
use App\Service\Product\Decorator\ProductDecorator;
use App\Service\Product\Decorator\ProductDecoratorInterface;
use App\Service\Product\Order\ProductOrderInterface;
use App\Service\Product\Strategy\ProductStrategy;
use App\Service\Product\Strategy\ProductStrategyInterface;
use Psr\Container\ContainerInterface;


class ProductPreparationService implements ProductPreparationInterface
{
    const MESSAGE_TO_WORK = 'Ваш заказ принят в работу';
    const MESSAGE_BASE = 'Выпечка основы';
    const MESSAGE_INGREDIENTS =  'Добавление ингредиентов';

    private ProductStrategyInterface $productStrategy;
    private ProductDecoratorInterface $productDecorator;

    public function __construct(ContainerInterface $container)
    {
        $this->productStrategy = $container->get(ProductStrategy::class);
        $this->productDecorator = $container->get(ProductDecorator::class);
    }


    public function process(ProductOrderInterface $order): ProductInterface
    {
        $order->setState(self::MESSAGE_TO_WORK);
        $this->prepare();

        $type = $order->getProductType();
        $factory = $this->productStrategy->getFactory($type);

        $order->setState(self::MESSAGE_BASE);
        $baseProduct = $factory->createProduct();
        $this->prepare();

        $order->setState(self::MESSAGE_INGREDIENTS);
        $this->productDecorator->setProduct($baseProduct);
        $ingredients = $order->getProductOptions()
            ? $order->getProductOptions()
            : $baseProduct->getDefaultOptions();
        $product = $this->productDecorator->addIngredients($ingredients);
        $this->prepare();

        return $product;
    }

    private function prepare(): void
    {
        sleep(rand(0, 2));
    }
}
