<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Config\Json;

use Nlazarev\Hw2_1\Model\File\IFile;
use Noodlehaus\Config;

class ConfigJson implements IConfigJson
{
    private Config $conf;

    public function fromFile(IFile $file)
    {
        if ($file->isReadable()) {
            $this->conf = new Config($file->getPath());
        } else {
            throw new \Exception("Config file is not loaded");
        }
    }

    public function getValueByKey($key)
    {
        return $this->conf->get($key);
    }
}
