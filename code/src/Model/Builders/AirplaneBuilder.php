<?php


namespace App\Model\Builders;


use App\Model\Airplane;
use App\Services\Orm\Interfaces\ModelBuilderInterface;
use DateTime;


class AirplaneBuilder implements ModelBuilderInterface
{
    public function build(array $raw): Airplane
    {
        $model = new Airplane();

        $buildDate = new DateTime($raw['build_date']);
        $model
            ->setId($raw['id'])
            ->setName($raw['name'])
            ->setNumber($raw['number'])
            ->setSeatsCount($raw['seats_count'])
            ->setBuildDate($buildDate)
            ->setAirlineId($raw['airline_id']);

        return $model;
    }

}
