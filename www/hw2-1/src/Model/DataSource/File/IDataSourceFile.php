<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\File;

use Nlazarev\Hw2_1\Model\DataSource\IDataSource;

interface IDataSourceFile extends IDataSource
{
    public function __construct(string $path);
    public function getPath(): string;
    public function isExists(): bool;
    public function isReadable(): bool;
}
