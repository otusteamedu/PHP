<?php

namespace App\Validators;

use App\Log\Log;

class HasPriorityValidator extends Validator
{
    public function check ($event): bool
    {
        Log::getInstance()->addRecord('has priority validation');

        if (!isset($event->priority) || !is_int($event->priority) || $event->priority <= 0) {
            Log::getInstance()->addRecord('error');

            return false;
        }

        Log::getInstance()->addRecord('success');

        return parent::check($event);
    }
}