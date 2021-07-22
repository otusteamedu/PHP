<?php

declare(strict_types=1);

namespace App\Model\Request\UseCase\Handle;

use App\Model\Request\Entity\Id;
use App\Model\Request\Repository\RequestRepositoryInterface;
use Exception;

class HandleRequestHandler
{
    private RequestRepositoryInterface $requestRepository;

    public function __construct(RequestRepositoryInterface $requestRepository)
    {
        $this->requestRepository = $requestRepository;
    }

    /**
     * @throws Exception
     */
    public function handle(HandleRequestCommand $command): void
    {
        $request = $this->requestRepository->getOne(new Id($command->id));

        $request->markAsHandled();

        $this->requestRepository->update($request);
    }
}