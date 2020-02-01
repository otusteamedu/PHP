<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;
use App\Controller\IndexController;
use App\Controller\LazyLoadController;
use App\Controller\NotFoundController;

class Application
{
    public static $app;
    private $config;
    private $db;
    public $request;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->db = $this->config->createDbClient();
        $this->request = new Request();
        self::$app = $this;
    }

    /**
     * @throws \Exception
     */
    public function run(): object
    {
        if (preg_match('~^/lazy_load[/]?$~', $this->request->get('uri'))) {

            $controller = new LazyLoadController();

        } elseif (preg_match('~^/$~', $this->request->get('uri'))) {

            $controller = new IndexController();

        } else {

            $controller = new NotFoundController();

        }

        return $controller->handler();
    }

    public function getDb(): object
    {
        return $this->db;
    }

    public function isDev(): bool
    {
        return $this->config->getEnvironment() == 'dev' ?: false ;
    }

    public static function getCurrent(): Application
    {
        return self::$app;
    }
}