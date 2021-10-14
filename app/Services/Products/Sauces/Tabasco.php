<?php

namespace App\Services\Products\Sauces;


use App\Services\Factories\ProductFactory\ISauce;


class Tabasco extends Sauce implements ISauce
{

    const SAUCE_NAME = 'Табаско';


    /**
     * @param ISauce $sauce
     */
    public function __construct(ISauce $sauce)
    {
        parent::__construct();
        $this->sauce = $sauce;
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
     * @return Tabasco
     */
    public function setType(string $type): Tabasco
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $this->saucesList = $this->sauce->toArray();
        $this->saucesList['Tabasco'] = parent::sauceToArray();
        return $this->saucesList;
    }
}