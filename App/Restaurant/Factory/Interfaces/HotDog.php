<?php


namespace App\Restaurant\Factory\Interfaces;



interface HotDog
{
    public function cook();
    public function ingredients(): Ingredients;

}