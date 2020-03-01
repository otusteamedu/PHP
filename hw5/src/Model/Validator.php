<?php

namespace Sergey\Otus\Model;

class Validator
{
    /**
     * @param string $value
     * @param string $message
     * @return bool
     */
    public function validate($value, &$message)
    {
        if (!$value) {
            $message = 'Value is empty';

            return false;
        }

        $cValue = $value;
        $count = substr_count($value, '(');

        for ($i = 0; $i < $count + 1; $i++) {
            $cValue = str_replace('()', '', $cValue);
        }

        if ($cValue) {
            $message = 'Value is not valid';

            return false;
        }

        $message = 'Value "' . $value . '" is valid';

        return true;
    }
}