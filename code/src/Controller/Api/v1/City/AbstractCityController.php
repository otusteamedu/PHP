<?php


namespace App\Controller\Api\v1\City;


use App\Controller\Api\Traits\JsonResponseTrait;
use App\Service\City\CityServiceInterface;

abstract class AbstractCityController
{
    use JsonResponseTrait;

    protected CityServiceInterface $cityService;

    /**
     * AbstractCityController constructor.
     * @param \App\Service\City\CityServiceInterface $cityService
     */
    public function __construct(CityServiceInterface $cityService)
    {
        $this->cityService = $cityService;
    }

}
