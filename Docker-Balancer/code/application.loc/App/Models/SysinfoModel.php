<?php

namespace App\Models;

use App\Exceptions\Checkers\InvalidCheckerException;
use App\Services\Checkers\CheckersFactory;
use App\Services\Checkers\Inspector;
use App\Services\Checkers\Sysinfo\NodeAddressChecker;
use App\Services\Checkers\Sysinfo\SapiChecker;
use App\Services\Checkers\Sysinfo\ServerAddressChecker;
use Exception;
use JetBrains\PhpStorm\ArrayShape;


class SysinfoModel extends BaseModel
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
    public function getNodeAddress(): array
    {
        $nodeIp = getHostByName(php_uname('n')) ?: 'Not defined';
        return ['info' => $nodeIp];
    }

    /**
     * @return array
     */
    public function getSapi(): array
    {
        $sapi = php_sapi_name() ?: 'Not defined';
        return ['info' => $sapi];
    }
}