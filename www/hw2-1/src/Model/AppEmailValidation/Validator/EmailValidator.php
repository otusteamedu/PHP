<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\AppEmailValidation\Validator;

use Nlazarev\Hw2_1\Model\Validators\StringObject\ValidatorStringObjectIsEmail;

final class EmailValidator extends ValidatorStringObjectIsEmail implements IEmailValidator
{
}
