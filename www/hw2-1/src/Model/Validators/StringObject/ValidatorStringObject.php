<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Validators\StringObject;

use Nlazarev\Hw2_1\Model\General\String\IStringObject;

class ValidatorStringObject implements IValidatorStringObject, IValidatorStringObjectToRegExp
{
    public function isValidStringObject(IStringObject $stringObject): bool
    {
        if ($stringObject->isNull()) {
            return false;
        }

        if ($stringObject->isEmpty()) {
            return false;
        }

        return true;
    }

    public function isValidToRegExpStringObject(IStringObject $string_object, IStringObject $regexp): bool
    {
        if (!$this->isValidStringObject($string_object)) {
            return false;
        }

        if (!$this->isValidStringObject($regexp)) {
            return false;
        }

        if (preg_match($regexp->getValue(), $string_object->getValue()) === 0) {
            return false;
        }

        return true;
    }
}
