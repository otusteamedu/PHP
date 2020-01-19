<?php

declare(strict_types=1);

namespace App\Kernel;

use App\Configs\Config;
use App\Controller\IndexController;
use App\Controller\LoadDataController;
use App\Controller\NotFoundController;
use App\Controller\SumLikesController;
use App\Controller\TopChannelsController;

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
        if (preg_match('~^/sum_likes[/]?$~', $this->request->get('uri'))) {

            $controller = new SumLikesController($this);

        } elseif (preg_match('~^/top_channels[/]?$~', $this->request->get('uri'))) {

            $controller = new TopChannelsController($this);

        } elseif (preg_match('~^/load_data[/]?$~', $this->request->get('uri'))) {

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