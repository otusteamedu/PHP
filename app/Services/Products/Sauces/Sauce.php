<?php

namespace App\Services\Products\Sauces;


use App\Services\Factories\ProductFactory\ISauce;
use JetBrains\PhpStorm\ArrayShape;


class Sauce implements ISauce
{

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

    protected string $status = '';
    protected string $name = '';
    protected string $type = '';


    public function __construct()
    {
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
        return $this;
    }

    /**
     * @return ISauce
     */
    public function setStatusWait(): ISauce
    {
        $this->status = self::SAUCE_STATUS['wait'];
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
}