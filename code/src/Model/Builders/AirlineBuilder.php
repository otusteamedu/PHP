<?php


namespace App\Model\Builders;


use App\Model\Airline;
use App\Services\Orm\Interfaces\ModelBuilderInterface;

class AirlineBuilder implements ModelBuilderInterface
{
    public function build(array $raw): Airline
    {
        $model = new Airline();
        $model
            ->setId($raw['id'])
            ->setName($raw['name'])
            ->setAbbreviation($raw['abbreviation'])
            ->setDescription($raw['description']);

        return $model;
    }
}
