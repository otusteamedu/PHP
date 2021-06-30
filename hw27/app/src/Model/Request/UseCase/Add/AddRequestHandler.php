<?php

declare(strict_types=1);

namespace App\Model\Request\UseCase\Add;

use App\Model\Request\Entity\Id;
use App\Model\Request\Entity\Request;
use App\Model\Request\Repository\RequestRepositoryInterface;
use App\Service\Queue\QueueClientInterface;
use DateTimeImmutable;
use Exception;

class AddRequestHandler
{
    private QueueClientInterface       $queueClient;
    private RequestRepositoryInterface $requestRepository;

    public function __construct(QueueClientInterface $queueClient, RequestRepositoryInterface $requestRepository)
    {
        $this->queueClient = $queueClient;
        $this->requestRepository = $requestRepository;
    }

    /**
     * @throws Exception
     */
    public function handle(AddRequestCommand $command): void
    {
        $this->requestRepository->add($this->buildRequest($command));

        $this->queueClient->connect();
        $this->queueClient->publish('handling-requests', ['id' => $command->id]);
        $this->queueClient->disconnect();
    }

    private function buildRequest(AddRequestCommand $command): Request
    {
        return new Request(
            new Id($command->id),
            $command->name,
            new DateTimeImmutable()
        );
    }

}