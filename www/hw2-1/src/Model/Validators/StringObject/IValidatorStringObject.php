<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators\StringObject;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;

interface IValidatorStringObject
{
    public function isValidStringObject(IStringObject $object): bool;
}
