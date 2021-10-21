<?php

namespace App\Http\Controllers;


use App\Http\Response\IResponse;
use App\Models\FastFoodModel;
use Illuminate\Container\Container;


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
     * @param Container $container
     */
    public function __construct(IResponse $response, Container $container)
    {
        parent::__construct($response, $container);
        $this->data['title'] = 'FastFood';
    }

    /**
     * Обработчик маршрута по умолчанию
     */
    public function run(): void
    {
        //TODO
    }
}