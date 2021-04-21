<?php


namespace App\Entity;


interface IngredientInterface
{
    public function getName(): string;
    public function setDouble(): void;
    public function __toString(): string;
}
