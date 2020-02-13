<?php

namespace App\Controller;

use App\Core\Bootstrap;

abstract class AppController
{
    protected ?Bootstrap $app;

    /**
     * AppController constructor.
     * @param Bootstrap|null $app
     */
    public function __construct(?Bootstrap $app = null)
    {
        $this->app = $app;
    }

    /**
     * @param string $pageFile
     */
    public function showPage(string $pageFile)
    {
        if (file_exists($pageFile)) {
            include $pageFile;
        }
    }

    /**
     * @return Bootstrap
     */
    public function getApp(): Bootstrap
    {
        return $this->app;
    }

    /**
     * @param Bootstrap $app
     * @return AppController
     */
    public function setApp(Bootstrap $app): AppController
    {
        $this->app = $app;
        return $this;
    }
}