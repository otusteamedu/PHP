<?php

namespace App\Services\Products\Sauces;


use App\Services\Factories\ProductFactory\ISauce;
use JetBrains\PhpStorm\ArrayShape;
use SplObjectStorage;
use SplObserver;
use SplSubject;


class Sauce implements ISauce, SplSubject
{
    const COMPONENT_NAME = 'СОУС';

    const SAUCE_STATUS = [
        'ready'     => 'Добавлен',
        'wait'      => 'Необходимо добавить',
    ];

    const SAUCE_NAME = '';

    /**
     * Набор ингредиентов для продукта
     * ['название ингредиента' => 'Статус']
     *
     * Например:
     * ['Onion' => 'В составе']
     *
     * @var array
     */
    protected array $saucesList = [];

    /**
     * Объект для обертывания (Decorator)
     *
     * @var ISauce|null
     */
    protected ?ISauce $sauce = null;

    /**
     * Список подключенных слушателей
     *
     * @var SplObjectStorage
     */
    private SplObjectStorage $observerList;

    protected string $status = '';
    protected string $name = '';
    protected string $type = '';


    public function __construct()
    {
        $this->observerList = new SplObjectStorage();
        $this->name = static::SAUCE_NAME;
    }

    /**
     * @return string
     */
    public function getSauces(): string
    {
        $last = array_key_last($this->saucesList);
        return array_reduce(
            array_map(
                static fn($key, $item) => ($key !== $last)
                    ? $item['name'] . " '" . $item['type'] . "' - " . $item['status'] . ", "
                    : $item['name'] . " '" . $item['type'] . "' - " . $item['status'] . PHP_EOL,
                array_keys($this->saucesList), $this->saucesList
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
     * @return self
     */
    public function addToRecipe(): self
    {
        if (is_null($this->sauce)) {
            return $this;
        }
        $this->sauce->addToRecipe();
        $this->setStatusWait();
        return $this;
    }

    /**
     * @return self
     */
    public function addToProduct(): self
    {
        if (is_null($this->sauce)) return $this;
        $this->sauce->addToProduct();
        $this->setStatusReady();
        return $this;
    }

    /**
     * @return ISauce
     */
    public function setStatusReady(): ISauce
    {
        $this->status = self::SAUCE_STATUS['ready'];
        $this->notify();
        return $this;
    }

    /**
     * @return ISauce
     */
    public function setStatusWait(): ISauce
    {
        $this->status = self::SAUCE_STATUS['wait'];
        $this->notify();
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
    public function sauceToArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status
        ];
    }

    public function attach(SplObserver $observer)
    {
        if (is_null($this->sauce)) {
            return $this;
        }
        $this->sauce->attach($observer);
        $this->observerList->attach($observer);
        return $this;
    }

    public function detach(SplObserver $observer)
    {
        if (is_null($this->sauce)) {
            return $this;
        }
        $this->sauce->detach($observer);
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