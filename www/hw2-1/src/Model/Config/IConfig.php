<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Config;

interface IConfig
{
    public function getValueByKey($key);
}
