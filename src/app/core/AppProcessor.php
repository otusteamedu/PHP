<?php

namespace Core;

use Throwable;

class AppProcessor
{
    /** @var AppRouter $router */
    private AppRouter $router;

    /** @var AppResponse */
    private AppResponse $response;

    /**
     * AppExecutor constructor.
     * @param AppRouter $router
     */
    public function __construct(AppRouter $router)
    {
        $this->router = $router;
        $this->response = new AppResponse();
    }

    public function validateRequest()
    {
        if (!$this->router->getNode()->isExists()) {
            $this->response->setCode(400);
        }
    }

    /**
     * @param AppConfig $appConfig
     */
    public function execute(AppConfig $appConfig)
    {
        try {
            $this->router->initAppController($appConfig, $this->response);
            $this->router->showPage();
            $this->router->callHandler();
        } catch (AppException $e) {
            $this->response->setContent($appConfig->isProduction() ? "Service temporarily unavailable" : $e->getMessage())->setCode(500);
        } catch (Throwable $e) {
            $this->response->setContent($appConfig->isProduction() ? "" : $e->getMessage())->setCode(500);
        }
    }

    /**
     * @return AppResponse
     */
    public function getResponse(): AppResponse
    {
        return $this->response;
    }
}