<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Film\FilmProxy;
use App\Entity\Session\SessionProxy;
use App\Entity\Ticket\Ticket;
use App\Exceptions\ExistClassException;
use App\Exceptions\KernelException;
use App\Kernel\Application;
use App\Kernel\RequestInterface;
use App\Kernel\Response;
use App\Kernel\ResponseInterface;
use App\Repository\RepositoryInterface;
use App\Repository\TicketRepository;
use ReflectionException;

class LazyLoadController implements ControllerInterface
{
    /**
     * @var RepositoryInterface
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
     * @throws ExistClassException
     */
    public function handler()
    {
        $filter = $this->request->getAll();

        $findResult = $this->ticketRepository->find($filter);

        foreach ($findResult as $item) {
            /**
             * @var Ticket $item
             * @var SessionProxy $session
             * @var FilmProxy $film
             */
            $session = $item->getSession();
            // получаем свойство, которое не загруженно,
            // чтобы получить все свойства сущности Session,
            // сохраненные в БД
            $sessionStart = $session->getProperty('start');
            $film = $session->getProperty('film');
            // также получаем все свойства сущности Film
            $filmName = $film->getProperty('name');
        }

        /**
         * @var ResponseInterface
         */
        $response = new Response($findResult);

        $response->send();
    }
}



