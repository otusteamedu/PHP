<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators;

use Nlazarev\Hw2_1\Model\Validators\StringObject\IValidatorStringObjectIsBracketsString;
use Nlazarev\Hw2_1\Model\Validators\StringObject\IValidatorStringObjectIsEmail;

interface IValidator extends IValidatorStringObjectIsBracketsString, IValidatorStringObjectIsEmail
{
    
}
