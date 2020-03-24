<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Controller\IndexController;
use App\Controller\NotFoundController;
use App\Controller\TicketBookingController;
use App\Controller\TicketBookingResultController;
use Exception;

class Router implements RouterInterface
{
    public $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function findController(): string
    {
        if (preg_match('~^/ticket_booking[/]?$~', $this->request->get('uri'))) {

            $controller = TicketBookingController::class;

        } elseif (preg_match('~^/queue_result[/]?$~', $this->request->get('uri'))) {

            $controller = TicketBookingResultController::class;

        } elseif (preg_match('~^/$~', $this->request->get('uri'))) {

            $controller = IndexController::class;

        } else {

            $controller = NotFoundController::class;

        }

        return $controller;
    }
}