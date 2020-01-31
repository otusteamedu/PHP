<?php

namespace Controller;

use Core\AppConfig;
use Core\AppResponse;

abstract class JsonAppController extends AppController
{
    public function __construct(AppResponse $response, AppConfig $appConfig)
    {
        parent::__construct($response, $appConfig);
        $response->setContentType(AppResponse::CONTENT_TYPE_JSON);
    }
}