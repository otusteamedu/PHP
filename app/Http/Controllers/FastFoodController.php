<?php

namespace App\Http\Controllers;

use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Response\IResponse;
use App\Models\FastFoodModel;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;


class FastFoodController extends BaseController
{
    /**
     * @var FastFoodModel|mixed
     */
    private mixed $model;

    /**
     * @param IResponse $response
     * @param Container $container
     */
    public function __construct(IResponse $response, Container $container)
    {
        parent::__construct($response, $container);
        $this->data['title'] = 'FastFood';
    }

    /**
     * Обработчик маршрута /FastFood/Burger
     *
     * @throws ViewLoaderException
     * @throws BindingResolutionException
     */
    public function burger(): void
    {
        $ingredients = $this->getParameters()['ingredients'] ?? [];
        $sauces = $this->getParameters()['sauces'] ?? [];
        $product = $this->getParameters()['product'] ?? '';

        $this->bind('Burger', $product['size'] ?? '');
        $this->model = $this->container->make(FastFoodModel::class);
        $burger = $this->model
            ->createProduct(customBaseType:$product['type'] ?? '', customIngredients:$ingredients, customSauces:$sauces)
            ->prepareProduct()
            ->getProduct();

        $this->data['burger'] = $burger;
        $this->data['sandwich'] = '';
        $this->data['hotDog'] = '';
        $this->loadView('Template/header');
        $this->loadView('Default/index');
        $this->loadView('Template/footer');
    }

    /**
     * Обработчик маршрута /FastFood/HotDog
     *
     * @throws BindingResolutionException
     * @throws ViewLoaderException
     */
    public function hotDog(): void
    {
        $ingredients = $this->getParameters()['ingredients'] ?? [];
        $sauces = $this->getParameters()['sauces'] ?? [];
        $product = $this->getParameters()['product'] ?? '';

        $this->bind('HotDog', $product['size'] ?? '');
        $this->model = $this->container->make(FastFoodModel::class);
        $hotDog = $this->model
            ->createProduct(customBaseType:$product['type'] ?? '', customIngredients:$ingredients, customSauces:$sauces)
            ->prepareProduct()
            ->getProduct();

        $this->data['burger'] = '';
        $this->data['sandwich'] = '';
        $this->data['hotDog'] = $hotDog;
        $this->loadView('Template/header');
        $this->loadView('Default/index');
        $this->loadView('Template/footer');
    }

    /**
     * Обработчик маршрута /FastFood/Sandwich
     *
     * @throws BindingResolutionException
     * @throws ViewLoaderException
     */
    public function sandwich(): void
    {
        $ingredients = $this->getParameters()['ingredients'] ?? [];
        $sauces = $this->getParameters()['sauces'] ?? [];
        $product = $this->getParameters()['product'] ?? '';

        $this->bind('Sandwich', $product['size'] ?? '');
        $this->model = $this->container->make(FastFoodModel::class);
        $sandwich = $this->model
            ->createProduct(customBaseType:$product['type'] ?? '', customIngredients:$ingredients, customSauces:$sauces)
            ->prepareProduct()
            ->getProduct();

        $this->data['burger'] = '';
        $this->data['sandwich'] = $sandwich;
        $this->data['hotDog'] = '';
        $this->loadView('Template/header');
        $this->loadView('Default/index');
        $this->loadView('Template/footer');
    }
}