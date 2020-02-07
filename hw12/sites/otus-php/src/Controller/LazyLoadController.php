<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use App\Repository\TicketRepository;
use ReflectionException;

class LazyLoadController
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

        $findResult = $this->ticketRepository->find($filter);

        foreach ($findResult as $item) {
            $session = $item->getSession();
            $sessionStart = $session->getProperty('start');
            $film = $session->getProperty('film');
            $filmName = $film->getProperty('name');
        }

        $response = new Response($findResult);

        $response->send();
    }
}



