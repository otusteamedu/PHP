<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 12.12.20
 * Time: 22:52
 */

namespace ClientServer;

use Exception;

class ClientServer extends Exception
{
    private $socket_path;
    private $error_mess = ['socket_path'=> 'Не указан файл сокета'];
    protected $type;
    public $socket_domain = AF_UNIX, $socket_type = SOCK_STREAM, $socket_protocol = 0;

    const CONFIG_FILE = '../setting/setting.ini';
    const ALLOWED_SERVER = 'cli';
    const ALLOWED_TYPE = ['server', 'client'];

    function __construct()
    {
        global $argv;
        error_reporting(E_ALL);

        //$this->validation($argv);
        $this->type = $argv[1];
        $this->readConfig();
    }

    private function readConfig($config_file = self::CONFIG_FILE) {
        $conf = parse_ini_file($config_file, true);

        foreach ($conf as $key => $set) {
            switch ($key){
                case 'socket_path':
                    unset($this->error_mess[$key]);
                    $this->socket_path = $set;
                    break;
                case 'socket_domain':
                    unset($this->error_mess[$key]);
                    $this->socket_domain = $set;
                    break;
                case 'socket_type':
                    unset($this->error_mess[$key]);
                    $this->socket_type = $set;
                    break;
                case 'socket_protocol':
                    unset($this->error_mess[$key]);
                    $this->socket_protocol = $set;
                    break;
                default: break;
            }
        }

        if (!empty($this->error_mess))
            throw new Exception(implode("\n", $this->error_mess));

    }

    public function run(){
        $connect = $this->getConnect();
        $connect->run();
    }

    public function getConnect()
    {
        //echo $this->type."****";
        switch ($this->type) {
            case 'server':
                return new Server($this->socket_path, $this->socket_domain, $this->socket_type, $this->socket_protocol);
            case 'client':
                return new Client($this->socket_path, $this->socket_domain, $this->socket_type, $this->socket_protocol);
        }
    }



}