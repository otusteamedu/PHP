<?php

declare(strict_types=1);

namespace App\Framework\Validator\Rules;

use DateTime;
use Exception;

class DateRule implements RuleInterface
{
    public function validate($value): bool
    {
        try {
            $date = new DateTime($value);
        } catch (Exception $e) {
            return false;
        }

        return checkdate(intval($date->format('m')), intval($date->format('d')), intval($date->format('Y')));
    }

    public function getErrorMessage(): string
    {
        return '%s должен быть датой в формате дд.мм.гггг';
    }
}