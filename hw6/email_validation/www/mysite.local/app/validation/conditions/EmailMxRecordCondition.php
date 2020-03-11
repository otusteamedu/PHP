<?php

namespace App\Validation\Condition;

use App\Util\EmailHelper;

class EmailMxRecordCondition implements ConditionInterface
{
    public function validate($data)
    {
        $host = EmailHelper::getHostFromEmail((string)$data);
        if ($host === '') {
            throw new \RuntimeException('Некорректный формат email');
        }

        $mxhosts = [];
        getmxrr($host, $mxhosts);

        if (empty($mxhosts)) {
            throw new \RuntimeException('Не найдены mx-записи');
        }
    }
}