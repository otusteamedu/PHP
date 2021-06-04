<?php


namespace App\Controller\Api;

use App\DTO\InterfaceDTO;
use App\Service\AirlineService\AirlineServiceInterface;
use App\Service\Security\SecurityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected SecurityInterface $security;
    protected LoggerInterface $logger;
    protected AirlineServiceInterface $airlineService;

    /**
     * AbstractController constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Service\Security\SecurityInterface $security
     * @param \Psr\Log\LoggerInterface $logger
     * @param \App\Service\AirlineService\AirlineServiceInterface $airlineService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        SecurityInterface $security,
        LoggerInterface $logger,
        AirlineServiceInterface $airlineService
    )
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
        $this->airlineService = $airlineService;
    }


    protected function jsonResponse(ResponseInterface $response, InterfaceDTO $dto): ResponseInterface
    {
        $response->getBody()->write(json_encode($dto));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($dto->getStatusCode());
    }

}
