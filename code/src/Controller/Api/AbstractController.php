<?php


namespace App\Controller\Api;

use App\DTO\InterfaceDTO;
use App\Service\AirlineService\AirlineServiceInterface;
use App\Service\CityService\CityServiceInterface;
use App\Service\Security\SecurityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected SecurityInterface $security;
    protected LoggerInterface $logger;
    protected AirlineServiceInterface $airlineService;
    protected CityServiceInterface $cityService;

    /**
     * AbstractController constructor.
     *
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Service\Security\SecurityInterface $security
     * @param \Psr\Log\LoggerInterface $logger
     * @param \App\Service\AirlineService\AirlineServiceInterface $airlineService
     * @param \App\Service\CityService\CityServiceInterface $cityService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SecurityInterface $security,
        LoggerInterface $logger,
        AirlineServiceInterface $airlineService,
        CityServiceInterface $cityService
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
        $this->airlineService = $airlineService;
        $this->cityService = $cityService;
    }


    protected function jsonResponse(ResponseInterface $response, InterfaceDTO $dto): ResponseInterface
    {
        $response->getBody()->write(json_encode($dto));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($dto->getStatusCode());
    }

}
