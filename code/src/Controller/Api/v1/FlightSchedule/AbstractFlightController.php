<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\Controller\Api\Traits\JsonResponseTrait;
use App\Service\FlightSchedule\FlightScheduleServiceInterface;
use Psr\Log\LoggerInterface;

class AbstractFlightController
{
    use JsonResponseTrait;

    protected FlightScheduleServiceInterface $flightScheduleService;
    protected LoggerInterface $logger;

    /**
     * FlightIndexController constructor.
     * @param \App\Service\FlightSchedule\FlightScheduleServiceInterface $flightScheduleService
     */
    public function __construct(FlightScheduleServiceInterface $flightScheduleService, LoggerInterface $logger)
    {
        $this->flightScheduleService = $flightScheduleService;
        $this->logger = $logger;
    }
}
