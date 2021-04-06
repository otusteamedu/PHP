<?php

namespace App\Validators;

use App\Log\Log;

class HasIdValidator extends Validator
{
    public function check ($event): bool
    {
        Log::getInstance()->addRecord('has id validation');

        if (!isset($event->id) || !is_int($event->id) || $event->id <= 0) {
            Log::getInstance()->addRecord('error');

            return false;
        }

        Log::getInstance()->addRecord('success');

        return parent::check($event);
    }
}