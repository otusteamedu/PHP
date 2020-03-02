<?php

namespace App\Controller;

use App\Core\Bootstrap;

abstract class AppController
{
    /**
     * @var Bootstrap|null
     */
    protected Bootstrap $app;

    /**
     * AppController constructor.
     * @param Bootstrap|null $app
     */
    public function __construct(?Bootstrap $app = null)
    {
        $this->app = $app ?? new Bootstrap();
    }

    /**
     * @param string $pageFile
     */
    public static function showPage(string $pageFile)
    {
        if (file_exists($pageFile)) {
            include $pageFile;
        }
    }
}