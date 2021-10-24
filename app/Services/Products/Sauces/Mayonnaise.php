<?php

namespace App\Services\Products\Sauces;


use App\Services\Factories\ProductFactory\ISauce;


class Mayonnaise extends Sauce implements ISauce
{

    const SAUCE_NAME = 'Майонез';


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
     * @return Mayonnaise
     */
    public function setType(string $type): Mayonnaise
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
        $this->saucesList['Mayonnaise'] = parent::sauceToArray();
        return $this->saucesList;
    }
}