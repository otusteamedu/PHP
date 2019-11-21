<?php

namespace Controllers;

use Core\AppConfig;
use Core\AppResponse;

abstract class AppController
{
    /** @var AppResponse $response */
    protected $response;

    /** @var AppConfig $appConfig */
    protected $appConfig;

    /**
     * AppController constructor.
     * @param AppResponse $response
     * @param AppConfig $config
     */
    public final function __construct(AppResponse $response, AppConfig $config)
    {
        $this->response = $response;
        $this->appConfig = $config;
    }
}