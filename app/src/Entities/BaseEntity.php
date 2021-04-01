<?php


namespace App\Entities;


abstract class BaseEntity
{
    abstract public function toArray() : array;
}