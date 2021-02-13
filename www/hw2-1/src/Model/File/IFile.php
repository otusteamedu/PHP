<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\File;

interface IFile
{
    public function setPath(string $path);
    public function getPath(): ?string;
    public function isExists(): bool;
    public function isReadable(): bool;
}
