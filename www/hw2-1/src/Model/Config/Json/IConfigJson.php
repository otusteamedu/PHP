<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Config\Json;

use Nlazarev\Hw2_1\Model\Config\IConfig;
use Nlazarev\Hw2_1\Model\File\IFromFile;

interface IConfigJson extends IConfig, IFromFile
{
}
