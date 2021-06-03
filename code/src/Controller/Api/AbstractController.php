<?php


namespace App\Controller\Api;

use App\DTO\InterfaceDTO;
use App\Service\Security\SecurityInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;

class AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected SecurityInterface $security;
    protected LoggerInterface $logger;

    /**
     * AbstractController constructor.
     * @param \Doctrine\ORM\EntityManagerInterface $entityManager
     * @param \App\Service\Security\SecurityInterface $security
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $entityManager, SecurityInterface $security, LoggerInterface $logger)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->logger = $logger;
    }


    protected function jsonResponse(ResponseInterface $response, InterfaceDTO $dto): ResponseInterface
    {
        $response->getBody()->write(json_encode($dto->getData()));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($dto->getStatusCode());
    }

}
