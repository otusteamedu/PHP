<?php


namespace App;

use App\Configs\Config;

class Application
{
    private $config;
    private $db;
    public $stat;
    public $request;
    public $response;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config = new Config();
        $this->db = $this->config->createDbClient();
        $this->stat = new Statistic($this->db);
        $this->request = new Request($_REQUEST);
        $this->response = new Response();
    }

    public function getDb(): object
    {
        return $this->db;
    }
}