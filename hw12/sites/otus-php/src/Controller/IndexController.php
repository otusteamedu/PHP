<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use App\Repository\TicketRepository;
use ReflectionException;

class IndexController
{
    /**
     * @var TicketRepository
     */
    private $ticketRepository;

    public function __construct()
    {
        $this->app = Application::getCurrent();
        $this->ticketRepository = new TicketRepository();
    }

    /**
     * @throws ReflectionException
     */
    public function handler(): Response
    {
        $filter = $this->app->request->getAll();

        $result = $this->ticketRepository->find($filter);

        $response = new Response($result);

        $response->send();
    }
}



