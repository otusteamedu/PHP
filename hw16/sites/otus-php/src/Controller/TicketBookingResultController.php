<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\KernelException;
use App\Kernel\Application;
use App\Kernel\RequestInterface;
use App\Kernel\Response;
use App\Repository\QueueResultRepository;
use App\Validators\QueueResultValidator;
use ReflectionException;

class TicketBookingResultController implements ControllerInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var QueueResultRepository
     */
    private $queueResultRepository;

    /**
     * @var QueueResultValidator
     */
    private $validator;

    /**
     * @param QueueResultRepository $queueResultRepository
     * @param QueueResultValidator $validator
     * @throws KernelException
     */
    public function __construct(QueueResultRepository $queueResultRepository, QueueResultValidator $validator)
    {
        $this->request = Application::getInstance('request');
        $this->queueResultRepository = $queueResultRepository;
        $this->validator = $validator;
    }

    /**
     * @throws ReflectionException
     * @throws KernelException
     * @throws \Exception
     */
    public function handler()
    {
        $queryBody = $this->request->getBody();
        $queryBody = json_decode($queryBody, true);

        $this->validator->validate($queryBody);

        $result = $this->queueResultRepository->find($queryBody);

        $response = new Response($result);
        $response->send();
    }
}



