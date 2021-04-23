<?php

namespace App\Shop\Adapters;


use App\Shop\Factory\Interfaces\Ingredients;
use App\Shop\IceCream;

class IceCreateIngredientsAdapter implements Ingredients
{

    private IceCream $item;

    public function __construct(IceCream $item)
    {
        $this->item = $item;
    }

    public function add(string $name): Ingredients
    {
        $this->toggle($name, true);
        return $this;
    }

    public function remove(string $name): Ingredients
    {
        $this->toggle($name, false);
        return $this;
    }


    private function toggle(string $name, bool $state): void
    {
        $method = 'add' . ucfirst($name);
        if (method_exists($this->item, $method)) {
            $this->item->$method($state);
        }
    }


    public function getAll(): array
    {
        return array_keys(array_filter($this->item->getStructure()));
    }
}