<?php

namespace App\Services\Checkers\Sysinfo;


use App\Exceptions\Checkers\Address\CannotGetIpAddressException;
use App\Exceptions\Checkers\Sysinfo\CannotGetSystemInfoException;
use App\Exceptions\ErrorCodes;
use App\Services\Checkers\AbstractChecker;


class NodeAddressChecker extends AbstractChecker
{
    /**
     * Запускает проверку
     *
     * @return NodeAddressChecker
     * @throws CannotGetSystemInfoException
     */
    public function check(): NodeAddressChecker
    {
        if (!getHostByName(php_uname('n'))) {
            throw new CannotGetSystemInfoException("The Node address is missing.", ErrorCodes::getCode(CannotGetSystemInfoException::class));
        }
        $this->info = getHostByName(php_uname('n'));
        return $this;
    }

}