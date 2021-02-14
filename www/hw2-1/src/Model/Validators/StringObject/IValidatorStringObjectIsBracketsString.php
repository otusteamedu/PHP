<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators\StringObject;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;

interface IValidatorStringObjectIsBracketsString extends IValidatorStringObject
{
    public function isStringObjectBalancedBracketsString(IStringObject $string_object): bool;
}
