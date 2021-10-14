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
    }

    /**
     * Обработчик маршрута по умолчанию
     */
    public function run(): void
    {
        echo "<pre>";
        $_REQUEST['product'] = [
            'name'  => 'Burger',
            'type'  => 'Без кунжута',
            'size'  => 'Большой',
        ];
        $_REQUEST['product'] = [
            'name'  => 'HotDog',
            'type'  => 'Булка с разрезом',
            'size'  => 'Средний',
        ];
        $_REQUEST['product'] = [
            'name'  => 'Sandwich',
            //'type'  => 'Ржаная',
            //'size'  => 'Маленький',
        ];

        $_REQUEST['sauces'] = ['mayonnaise' => 'Провансаль Московский', 'tabasco' => 'Классический'];
        $_REQUEST['ingredients'] = [
            'steak' => 'Сильной прожарки',
            'onion' => 'Зеленый репчатый',
            'pepper' => 'Черный',
        ];

        $ingredients = $_REQUEST['ingredients'] ?? [];
        $sauces = $_REQUEST['sauces'] ?? [];

        $product = $this->getParameters()['product'] ?? '';
        if (empty($product)) {
            return;
        }
        $this->model = new FastFoodModel($product);
        echo $this->model
            ->createProduct(customBaseType:$product['type'] ?? '', customIngredients:$ingredients, customSauces:$sauces)
            ->prepareProduct()
            ->getProduct();
    }
}