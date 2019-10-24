<?php

class SocketConfig
{
    public $clientAddress = "";
    public $clientDelay = 0;
    public $serverAddress = "";
    public $serverDelay = 0;
    public $exitCommand = "exit";
    public $helloServer = "hello";

    public function __construct(string $iniPath)
    {
        $conf = parse_ini_file($iniPath);
        $this->serverAddress = $conf["serverAddress"] ?? "";
        $this->serverDelay = intval($conf["serverDelay"] ?? 0);
        $this->clientAddress = $conf["clientAddress"] ?? "";
        $this->clientDelay = intval($conf["clientDelay"] ?? 0);
        $this->exitCommand = $conf["exitCommand"] ?? "exit";
        $this->helloServer = $conf["helloServer"] ?? "hello";
    }
}