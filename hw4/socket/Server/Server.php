<?php
namespace Server;

class Server
{
    private $conf;

    public function __construct()
    {
        $this->conf = parse_ini_file('config.ini');
        $this->sockerStart();
    }

    private function sockerStart()
    {

    }
}