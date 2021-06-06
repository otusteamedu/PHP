<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\Controller\Api\Traits\JsonResponseTrait;
use App\Service\FlightSchedule\FlightScheduleServiceInterface;
use App\Service\Request\RequestServiceInterface;

class AbstractFlightController
{
    use JsonResponseTrait;

    protected FlightScheduleServiceInterface $flightScheduleService;
    protected RequestServiceInterface $requestService;

    /**
     * FlightIndexController constructor.
     *
     * @param \App\Service\FlightSchedule\FlightScheduleServiceInterface $flightScheduleService
     * @param \App\Service\Request\RequestServiceInterface $requestService
     */
    public function __construct(FlightScheduleServiceInterface $flightScheduleService, RequestServiceInterface $requestService)
    {
        $this->flightScheduleService = $flightScheduleService;
        $this->requestService = $requestService;

    }
}
