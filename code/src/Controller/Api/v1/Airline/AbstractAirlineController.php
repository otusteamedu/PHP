<?php


namespace App\Controller\Api\v1\Airline;


use App\Controller\Api\Traits\JsonResponseTrait;
use App\Service\Airline\AirlineServiceInterface;

abstract class AbstractAirlineController
{
    use JsonResponseTrait;

    protected AirlineServiceInterface $airlineService;

    /**
     * AbstractAirlineController constructor.
     * @param \App\Service\Airline\AirlineServiceInterface $airlineService
     */
    public function __construct(AirlineServiceInterface $airlineService)
    {
        $this->airlineService = $airlineService;
    }

}
