<?php

namespace App\Controllers;

use Classes\Dto\EventDtoBuilder;
use Classes\ResponseHandler;
use Services\EventServiceImpl;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class DeliveryController
{
    private $eventServiceImpl;

    public function __construct(EventServiceImpl $eventServiceImpl)
    {
        $this->eventServiceImpl = $eventServiceImpl;
    }

    public function getList()
    {
        
    }


}
