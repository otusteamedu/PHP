<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;
use App\Controller\IndexController;
use App\Controller\LoadDataController;
use App\Controller\NotFoundController;
use App\Controller\RedisController;
use App\Controller\SumLikesController;

class Application
{
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
    }

    /**
     * @throws \Exception
     */
    public function run(): object
    {
        if (preg_match('~^/redis/add_event[/]?$~', $this->request->get('uri'))) {
            $controller = new RedisController($this);

            return $controller->addEvent();

        } elseif (preg_match('~^/redis/query_event[/]?$~', $this->request->get('uri'))) {
            $controller = new RedisController($this);

            return $controller->queryEvent();

        } elseif (preg_match('~^/redis/drop_events[/]?$~', $this->request->get('uri'))) {
            $controller = new RedisController($this);

            return $controller->dropEvents();

        } elseif (preg_match('~^/redis/load_data[/]?$~', $this->request->get('uri'))) {

            $controller = new LoadDataController($this);

        } elseif (preg_match('~^/$~', $this->request->get('uri'))) {

            $controller = new IndexController($this);

        } else {

            $controller = new NotFoundController($this);

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
}