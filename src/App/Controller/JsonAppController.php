<?php

namespace App\Controller;

use App\Core\Bootstrap;
use App\Core\ClientResponse;

abstract class JsonAppController extends AppController
{
    public function __construct(?Bootstrap $app = null)
    {
        parent::__construct($app);
        if ($app instanceof Bootstrap) {
            $this->app->getResponse()->setContentType(
                ClientResponse::CONTENT_TYPE_JSON
            );
        }
    }
}