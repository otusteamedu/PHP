<?php

namespace App\Services\Checkers\Sysinfo;


use App\Exceptions\Checkers\Address\CannotGetIpAddressException;
use App\Exceptions\Checkers\Sysinfo\CannotGetSystemInfoException;
use App\Exceptions\ErrorCodes;
use App\Services\Checkers\AbstractChecker;


class ServerAddressChecker extends AbstractChecker
{
    /**
     * Запускает проверку
     *
     * @return ServerAddressChecker
     * @throws CannotGetSystemInfoException
     */
    public function check(): ServerAddressChecker
    {
        if (!isset($_SERVER['SERVER_ADDR'])) {
            throw new CannotGetSystemInfoException("The server IP address is missing", ErrorCodes::getCode(CannotGetSystemInfoException::class));
        }
        $this->info = $_SERVER['SERVER_ADDR'];
        return $this;
    }
}