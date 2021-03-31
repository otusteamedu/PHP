<?php


namespace App\Model\Builders;


use App\Model\Airline;
use App\Services\Orm\Interfaces\ModelBuilderInterface;
use App\Services\Orm\ModelManager;

class AirlineBuilder implements ModelBuilderInterface
{
    private ModelManager $modelManager;

    /**
     * AirlineBuilder constructor.
     * @param ModelManager $mm
     */
    public function __construct(ModelManager $mm)
    {
        $this->modelManager = $mm;
    }

    public function build(array $raw): Airline
    {
        $model = new Airline($this->modelManager);
        $model
            ->setId($raw['id'])
            ->setName($raw['name'])
            ->setAbbreviation($raw['abbreviation'])
            ->setDescription($raw['description']);

        return $model;
    }
}
