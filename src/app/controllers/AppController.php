<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;

abstract class AppController
{
    /** @var AppResponse $appResponse */
    protected AppResponse $appResponse;

    /** @var AppConfig $appConfig */
    protected AppConfig $appConfig;

    /**
     * AppController constructor.
     * @param AppResponse $response
     * @param AppConfig $appConfig
     */
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        $this->appResponse = $response;
        $this->appConfig = $appConfig;
    }
}