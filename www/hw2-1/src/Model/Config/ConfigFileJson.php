<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Config;

use Noodlehaus\Config;

class ConfigFileJson implements IConfig
{
    private Config $conf;

    public function __construct(string $conf_path)
    {
        $this->conf = new Config($conf_path);
    }

    public function getValueByKey($key)
    {
        return $this->conf->get($key);
    }
}
