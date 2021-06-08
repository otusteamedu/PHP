<?php
declare(strict_types=1);

namespace Src;

use Exception;

class RequestValidator
{
    /**
     * @throws \Exception
     */
    public static function validate(array $params)
    {
        if (empty($params['email'])) {
            throw new Exception('Email field if required', 400);
        }
    }
}
