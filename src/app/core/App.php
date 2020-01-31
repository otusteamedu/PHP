<?php

namespace Core;

class App
{
    /** @var AppRequest $request */
    protected AppRequest $request;

    /** @var AppResponse $response */
    protected AppResponse $response;

    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->request = new AppRequest();
    }

    /**
     * @param AppConfig $appConfig
     */
    public function run(AppConfig $appConfig)
    {
        $router = new AppRouter($this->request->getRequestStr());

        $executor = new AppProcessor($router);
        $executor->validateRequest();
        $executor->execute($appConfig);

        $executor->getResponse()->flush();
    }
}