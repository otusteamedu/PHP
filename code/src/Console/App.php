<?php


namespace App\Console;


use App\Entity\Burger;
use App\Entity\HotDog;
use App\Entity\Sandwich;
use App\Service\Product\Order\ProductOrderService;
use App\Service\Product\Preparation\ProductPreparationProxy;
use App\Utils\Config\Config;
use Psr\Container\ContainerInterface;

class App extends Console
{
    private ContainerInterface $container;

    public function __construct()
    {
        $this->container = Config::buildContainer();
    }

    public function run()
    {
        list ($type, $ingredients) = $this->choiceProduct();
        if (!$type) {
            echo 'Bye', PHP_EOL;
            return;
        }
        echo 'Принято...', PHP_EOL, PHP_EOL;

        $email = 'user@mail.com';
        $orderService = $this->container->get(ProductOrderService::class);
        $order = $orderService->createOrder($email, $type, $ingredients);

        $preparationService = $this->container->get(ProductPreparationProxy::class);
        $product = $preparationService->process($order);

        echo $product, PHP_EOL;
    }

    private function choiceProduct(): ?array
    {
        $products = [
            1 => Burger::TYPE,
            2 => HotDog::TYPE,
            3 => Sandwich::TYPE,
        ];

        echo sprintf(
            '%s (1), %s (2), %s (3)%s',
            Burger::TYPE, HotDog::TYPE, Sandwich::TYPE, PHP_EOL
        );
        $key = $this->readLine();

        if (!array_key_exists($key, $products)) {
            echo 'Bad choice', PHP_EOL;
            return null;
        }

        $type = $products[$key];
        $ingredients = $this->changeIngredients($key);

        return [$type, $ingredients];
    }

    private function changeIngredients($key): ?array
    {
        echo 'Изменить ингредиенты? (y, [n]) ';
        if ('y' === $this->readLine()) {
            return $this->customIngredients($key);
        }

        return null;
    }

    private function customIngredients(int $productType): array
    {
        $ingredients = $this->getAvailableIngredients($productType);
        $userIngredients = [];

        foreach ($ingredients as $ingredient) {
            echo $ingredient, ' (y, [n]) ';
            $answer = $this->readLine();
            if ('y' === $answer) {
                $userIngredients[$ingredient] = $this->getIsDouble();
            }
        }

        return $userIngredients;
    }

    private function getIsDouble(): bool
    {
        echo 'Двойной ? (y, [n]) ';
        if ('y' === $this->readLine()) {
            return true;
        }

        return false;
    }

    private function getAvailableIngredients(int $productType): array
    {
        switch ($productType) {
            case 1:
                return Burger::AVAILABLE_INGREDIENTS;
            case 2:
                return HotDog::AVAILABLE_INGREDIENTS;
            case 3:
                return Sandwich::AVAILABLE_INGREDIENTS;
        }
    }

}

