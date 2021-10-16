<?php

namespace App\Http\Controllers;


use App\Http\Response\IResponse;
use App\Models\FastFoodModel;


/**
 * Контроллер по умолчанию.
 */
class DefaultController extends BaseController
{

    /**
     * @var FastFoodModel
     */
    private FastFoodModel $model;


    /**
     * @param IResponse $response
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->data['title'] = 'FastFood';
    }

    /**
     * Обработчик маршрута по умолчанию
     */
    public function run(): void
    {
        $_REQUEST['product'] = [
            'name'  => 'Sandwich',
            'type'  => 'Ржаная',
            'size'  => 'Маленький',
        ];
        $_REQUEST['sauces'] = [
            'mayonnaise' => 'Провансаль Московский',
            'tabasco' => 'Слабый'
        ];
        $ingredients = $_REQUEST['ingredients'] ?? [];
        $sauces = $_REQUEST['sauces'] ?? [];
        $product = $this->getParameters()['product'] ?? '';
        if (empty($product)) {
            return;
        }
        $this->model = new FastFoodModel($product);
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

    public function burger(): void
    {
        $_REQUEST['product'] = [
            'name'  => 'Burger',
            'type'  => 'Без кунжута',
            'size'  => 'Большой',
        ];
        $_REQUEST['ingredients'] = [
            'steak' => 'Сильной прожарки',
            'onion' => 'Зеленый репчатый',
            'pepper' => 'Болгарский',
        ];
        $_REQUEST['sauces'] = [
            'mayonnaise' => 'Провансаль Московский',
            'tabasco' => 'Классический'
        ];

        $ingredients = $_REQUEST['ingredients'] ?? [];
        $sauces = $_REQUEST['sauces'] ?? [];

        $product = $this->getParameters()['product'] ?? '';
        if (empty($product)) {
            return;
        }

        $this->model = new FastFoodModel($product);
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

    public function HotDog(): void
    {
        $_REQUEST['product'] = [
            'name'  => 'HotDog',
            'type'  => 'Булка с разрезом',
            'size'  => 'Средний',
        ];
        $_REQUEST['sauces'] = ['mayonnaise' => 'Ряба', 'tabasco' => 'Острый'];
        $_REQUEST['ingredients'] = [
            'sausage' => 'Сливочная',
            'onion' => 'Зеленый. Перья',
            'pepper' => 'Черный',
        ];
        $ingredients = $_REQUEST['ingredients'] ?? [];
        $sauces = $_REQUEST['sauces'] ?? [];
        $product = $this->getParameters()['product'] ?? '';
        if (empty($product)) {
            return;
        }
        $this->model = new FastFoodModel($product);
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
}