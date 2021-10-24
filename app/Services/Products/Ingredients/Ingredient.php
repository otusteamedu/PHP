<?php

namespace App\Services\Products\Ingredients;

use App\Services\Factories\ProductFactory\IIngredient;
use JetBrains\PhpStorm\ArrayShape;
use SplObjectStorage;
use SplObserver;
use SplSubject;


class Ingredient implements IIngredient, SplSubject
{
    const INGREDIENT_STATUS = [
        'ready'     => 'Добавлен',
        'wait'      => 'Необходимо добавить',
        'prepare'   => 'Готовится'
    ];

    const INGREDIENT_NAME = '';

    const COMPONENT_NAME = 'ИНГРЕДИЕНТ';

    /**
     * Набор ингредиентов для продукта
     * ['название ингредиента' => 'Статус']
     *
     * Например:
     * ['Onion' => 'В составе']
     *
     * @var array
     */
    protected array $ingredientsList = [];

    /**
     * Список подключенных слушателей
     *
     * @var SplObjectStorage
     */
    protected SplObjectStorage $observerList;

    protected string $status = '';
    protected string $name = '';
    protected string $type = '';

    /**
     * Объект для обертывания (Decorator)
     *
     * @var IIngredient|null
     */
    protected ?IIngredient $ingredient = null;


    public function __construct()
    {
        $this->observerList = new SplObjectStorage();
        $this->name = static::INGREDIENT_NAME;
    }

    /**
     * Возвращает все ингредиенты
     *
     * @return string
     */
    public function getIngredients(): string
    {
        $last = array_key_last($this->ingredientsList);
        return array_reduce(
            array_map(
                static fn($key, $item) => ($key !== $last)
                    ? $item['name'] . " '" . $item['type'] . "' - " . $item['status'] . ", "
                    : $item['name'] . " '" . $item['type'] . "' - " . $item['status'] . PHP_EOL,
                array_keys($this->ingredientsList), $this->ingredientsList
            ),
            static  fn($carry, $item) => $carry .= $item,
            ''
        );
    }

    /**
     * Возвращает информацию о конкретном текущем ингредиенте
     *
     * @return string
     */
    public function getInfo(): string
    {
        return self::COMPONENT_NAME . ": " . $this->name . " '" . $this->type . "' - " . $this->status;
    }

    /**
     * @return IIngredient
     */
    public function addToRecipe(): IIngredient
    {
        if (is_null($this->ingredient)) {
            return $this;
        }
        $this->ingredient->addToRecipe();
        $this->setStatusWait();
        return $this;
    }

    /**
     * @return IIngredient
     */
    public function addToProduct(): IIngredient
    {
        if (is_null($this->ingredient)) return $this;
        $this->ingredient->addToProduct();
        $this->setStatusReady();
        return $this;
    }

    /**
     * @return IIngredient
     */
    public function setStatusReady(): IIngredient
    {
        // TODO установить в базе статус готов
        $this->status = static::INGREDIENT_STATUS['ready'];
        $this->notify();
        return $this;
    }

    /**
     * @return IIngredient
     */
    public function setStatusWait(): IIngredient
    {
        $this->status = self::INGREDIENT_STATUS['wait'];
        $this->notify();
        return $this;
    }

    /**
     * @return IIngredient
     */
    public function setStatusPrepare(): IIngredient
    {
        $this->status = self::INGREDIENT_STATUS['prepare'];
        $this->notify();
        return $this;
    }

    /**
     * @return IIngredient
     */
    public function prepare(): IIngredient
    {
        if (is_null($this->ingredient)) return $this;
        $this->ingredient->prepare();
        // TODO отправить на готовку
        // TODO установить в базе статус приготовления
        $this->setStatusPrepare();
        sleep(0);
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return IIngredient
     */
    public function setType(string $type): IIngredient
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }

    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'type' => "string", 'status' => "string"])]
    public function ingredientToArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status
        ];
    }

    public function attach(SplObserver $observer)
    {
        if (is_null($this->ingredient)) {
            return $this;
        }
        $this->ingredient->attach($observer);
        $this->observerList->attach($observer);
        return $this;
    }

    public function detach(SplObserver $observer)
    {
        if (is_null($this->ingredient)) {
            return $this;
        }
        $this->ingredient->detach($observer);
        $this->observerList->detach($observer);
        return $this;
    }

    public function notify()
    {
        foreach ($this->observerList as $observer) {
            $observer->update($this);
        }
    }
}