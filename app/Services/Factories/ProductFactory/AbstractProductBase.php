<?php

namespace App\Services\Factories\ProductFactory;

use JetBrains\PhpStorm\ArrayShape;
use SplObjectStorage;
use SplSubject;
use SplObserver;

abstract class AbstractProductBase implements SplSubject
{
    const PRODUCT_BASE_STATUS = [
        'ready'     => 'Готова',
        'wait'      => 'Создан заказ',
        'prepare'   => 'Готовится'
    ];

    const PRODUCT_BASE_NAME = '';

    const COMPONENT_NAME = 'ОСНОВА';


    protected string $status = '';
    protected string $name = '';
    protected string $type = '';
    protected string $size = '';
    protected SplObjectStorage $observerList;


    public function __construct()
    {
        $this->observerList = new SplObjectStorage();
        $this->name = static::PRODUCT_BASE_NAME;
    }

    /**
     * @return string
     */
    public function getProductBase(): string
    {
        return $this->name .  " '" . $this->getType() . "', размер: " . $this->size . " - " . $this->status . PHP_EOL;
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return self::COMPONENT_NAME . ": " . $this->getProductBase();
    }

    /**
     * @return AbstractProductBase
     */
    public function addToRecipe(): AbstractProductBase
    {
        $this->setStatusWait();
        return $this;
    }

    /**
     * @return AbstractProductBase
     */
    public function setStatusReady(): AbstractProductBase
    {
        // TODO установить в базе статус готов
        $this->status = static::PRODUCT_BASE_STATUS['ready'];
        $this->notify();
        return $this;
    }

    /**
     * @return AbstractProductBase
     */
    public function setStatusWait(): AbstractProductBase
    {
        $this->status = self::PRODUCT_BASE_STATUS['wait'];
        $this->notify();
        return $this;
    }

    /**
     * @return AbstractProductBase
     */
    public function setStatusPrepare(): AbstractProductBase
    {
        $this->status = self::PRODUCT_BASE_STATUS['prepare'];
        $this->notify();
        return $this;
    }

    /**
     * @return AbstractProductBase
     */
    public function prepare(): AbstractProductBase
    {
        // TODO отправить на готовку
        // TODO установить в базе статус приготовления
        $this->setStatusPrepare();
        return $this;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     * @return AbstractProductBase
     */
    public function setSize(string $size): AbstractProductBase
    {
        $this->size = $size;
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
     * @return AbstractProductBase
     */
    public function setType(string $type): AbstractProductBase
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @return array
     */
    #[ArrayShape(['name' => "string", 'type' => "string", 'status' => "string"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'status' => $this->status
        ];
    }

    public function attach(SplObserver $observer)
    {
        $this->observerList->attach($observer);
        return $this;
    }

    public function detach(SplObserver $observer)
    {
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