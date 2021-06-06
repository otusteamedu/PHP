<?php


namespace App\Service\FlightSchedule;


use App\Service\CrudInterface;
use JsonSerializable;

interface FlightScheduleServiceInterface extends CrudInterface
{
    public function findByDate(string $date): ?array;
}
