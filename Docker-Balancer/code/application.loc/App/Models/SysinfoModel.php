<?php

namespace App\Models;

use JetBrains\PhpStorm\ArrayShape;


class SysinfoModel implements IModel
{
    #[ArrayShape([
        'webserverIp' => "array|string[]",
        'nodeIp' => "array|string[]",
        'sapi' => "array|string[]"
    ])]
    public function getSysInfo(): array
    {
        return [
            'webserverIp' => $this->getServerAddress(),
            'nodeIp' => $this->getNodeAddress(),
            'sapi' => $this->getSapi(),
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['info' => "mixed|string"])]
    public function getServerAddress(): array
    {
        $serverIp = $_SERVER['SERVER_ADDR'] ?? 'Not defined';
        return ['info' => $serverIp];
    }

    /**
     * @return array
     */
    #[ArrayShape(['info' => "string"])]
    public function getNodeAddress(): array
    {
        $nodeIp = getHostByName(php_uname('n')) ?: 'Not defined';
        return ['info' => $nodeIp];
    }

    /**
     * @return array
     */
    #[ArrayShape(['info' => "false|string"])]
    public function getSapi(): array
    {
        $sapi = php_sapi_name() ?: 'Not defined';
        return ['info' => $sapi];
    }
}