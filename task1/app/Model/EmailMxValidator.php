<?php

namespace App\Model;

use App\Api\ValidatorInterface;

class EmailMxValidator implements ValidatorInterface
{
    /**
     * @param string $input
     * @return bool
     */
    public function validate($input): bool
    {
        preg_match('/@(.*)/', $input, $matches);
        if (!isset($matches[1])) {
            return false;
        }
        getmxrr($matches[1], $mxHosts);
        return count($mxHosts) > 0;
    }

}