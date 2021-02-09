<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\AppEmailValidation\RegExp;

use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\General\String\IStringObject;

interface IEmailRegExp extends IStringObject
{
    public function fromConfig(IConfig $conf);
}
