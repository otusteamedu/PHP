<?php

namespace App\Services\Checkers\Sysinfo;


use App\Exceptions\Checkers\Sysinfo\CannotGetSystemInfoException;
use App\Exceptions\ErrorCodes;
use App\Services\Checkers\AbstractChecker;


class SapiChecker extends AbstractChecker
{
    /**
     * @return SapiChecker
     * @throws CannotGetSystemInfoException
     */
    public function check(): SapiChecker
    {
        if (!php_sapi_name()) {
            throw new CannotGetSystemInfoException("Cant get Sapi information", ErrorCodes::getCode(CannotGetSystemInfoException::class));
        }
        $this->info = php_sapi_name();
        return $this;
    }
}