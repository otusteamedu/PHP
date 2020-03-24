<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exceptions\KernelException;
use App\Kernel\Application;
use App\Kernel\RequestInterface;
use App\Kernel\Response;
use App\Queue\QueueClientInterface;
use App\Service\TicketBookingService;
use ReflectionException;

class TicketBookingController implements ControllerInterface
{
    /**
     * @var TicketBookingService
     */
    private $ticketBookingService;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @throws \Exception
     * @var QueueClientInterface $queueClient
     */
    public function __construct()
    {
        /**
         * @var QueueClientInterface $queueClient
         */
        $queueClient = Application::getInstance('queueClient');
        $this->ticketBookingService = new TicketBookingService($queueClient);

        $this->request = Application::getInstance('request');
    }

    /**
     * @throws ReflectionException
     * @throws KernelException
     * @throws \Exception
     */
    public function handler()
    {
        $queryBody = $this->request->getBody();

        $messageId = $this->ticketBookingService->sendTicketsForBooking(json_decode($queryBody, true));

        $response = new Response($messageId);
        $response->send();
    }
}



