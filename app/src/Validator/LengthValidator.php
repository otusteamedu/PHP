<?php

namespace Validator;

class LengthValidator extends AbstractValidator
{
    const VIOLATION = 'Not defined content length or content length is not correct;';

    /** @inheritDoc */
    public function validate()
    {
        if (array_key_exists('Content-Length', $this->headers)) {
            $contentLength = (int)$this->headers['Content-Length'];
            if (array_key_exists('string', $this->request)
                && strlen('string=' . rawurlencode($this->request['string'])) == $contentLength) {
                 return true;
            }
        }
        return false;
    }
}
