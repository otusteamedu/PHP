<?php

namespace crazydope\validation;

class HostValidator
    extends AbstractValidator
{
    protected const INVALID = 'The input is not a valid. String expected. ';
    protected const INVALID_URI = 'Not valid URI hostname. ';

    public function isValid( $value ): bool
    {
        if ( !is_string($value) ) {
            $this->addError(self::INVALID);
            return false;
        }

        if ( preg_match('/^([\p{Cyrillic}\p{Latin}\d\.-]{1,64})?\.(?:\x{0440}\x{0444}|ru|su|com|net|org|mil|edu|arpa|gov|biz|info|aero|inc|name|[a-z]{2,4})$/iu', $value) ) {
            return true;
        }

        $this->addError(self::INVALID_URI);

        return false;
    }
}