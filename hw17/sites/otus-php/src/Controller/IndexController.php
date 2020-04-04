<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\KernelException;
use App\Kernel\Application;
use App\Kernel\RequestInterface;
use App\Kernel\Response;
use App\Repository\TicketRepository;
use ReflectionException;

class IndexController implements ControllerInterface
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param TicketRepository $ticketRepository
     * @throws KernelException
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->request = Application::getInstance('request');
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * @throws ReflectionException
     */
    public function handler()
    {
        $filter = $this->request->getAll();

        $result = $this->ticketRepository->find($filter);

        $response = new Response($result);

        $response->send();
    }
}
