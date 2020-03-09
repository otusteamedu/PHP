<?php

namespace App\Controller;

use App\Core\Bootstrap;
use App\Core\ClientResponse;

abstract class ApiController
{
    protected Bootstrap $app;

    /**
     * ApiController constructor.
     * @param Bootstrap $app
     */
    public function __construct(Bootstrap $app)
    {
        $this->app = $app;
        $app->getResponse()->setContentType(
            ClientResponse::CONTENT_TYPE_JSON
        );
    }
}