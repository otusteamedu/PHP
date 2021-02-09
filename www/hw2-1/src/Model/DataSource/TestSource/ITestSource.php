<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\DataSource\TestSource;

interface ITestSource
{
    public function __construct(array $source);
    public function getSource(): array;
}
