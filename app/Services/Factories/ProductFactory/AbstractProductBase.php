<?php

namespace App\Services\Factories\ProductFactory;

use JetBrains\PhpStorm\ArrayShape;

abstract class AbstractProductBase
{
    const PRODUCT_BASE_STATUS = [
        'ready'     => 'Готова',
        'wait'      => 'Необходимо добавить',
        'prepare'   => 'Готовится'
    ];

    const PRODUCT_BASE_NAME = '';


    protected string $status = '';
    protected string $name = '';
    protected string $type = '';
    protected string $size = '';

    //abstract public function prepareProduct(): void;
    //abstract public function setStatusReady(): void;


    public function __construct()
    {
        $this->name = static::PRODUCT_BASE_NAME;
        $this->addToRecipe();
    }

    /**
     * @return string
     */
    public function getProductBase(): string
    {
        return $this->name .  " '" . $this->getType() . "', размер: " . $this->size . " - " . $this->status . PHP_EOL;
    }

    /**
     * @return AbstractProductBase
     */
    protected function addToRecipe(): AbstractProductBase
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
        return $this;
    }

    /**
     * @return AbstractProductBase
     */
    public function setStatusWait(): AbstractProductBase
    {
        $this->status = self::PRODUCT_BASE_STATUS['wait'];
        return $this;
    }

    /**
     * @return AbstractProductBase
     */
    public function setStatusPrepare(): AbstractProductBase
    {
        $this->status = self::PRODUCT_BASE_STATUS['prepare'];
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

}