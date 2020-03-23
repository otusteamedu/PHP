<?php

namespace App\Validation\Condition;

use App\Exceptions\ValidationErrorException;
use App\Util\EmailHelper;

class EmailMxRecordCondition implements ConditionInterface
{
    public function validate($data)
    {
        $host = EmailHelper::getHostFromEmail((string)$data);
        if ($host === '') {
            throw new ValidationErrorException('Некорректный формат email');
        }

        $mxhosts = [];
        getmxrr($host, $mxhosts);

        if (empty($mxhosts)) {
            throw new ValidationErrorException('Не найдены mx-записи');
        }
    }
}