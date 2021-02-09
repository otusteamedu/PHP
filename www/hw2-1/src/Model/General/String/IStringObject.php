<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\General\String;

use Nlazarev\Hw2_1\Model\General\IObject;

interface IStringObject extends IObject
{
    public function __construct(?string $value);
    public function getValue(): ?string;
    public function setValue(?string $value);
    public function getLength(): int;
    public function isNull(): bool;
    public function isEmpty(): bool;
}
