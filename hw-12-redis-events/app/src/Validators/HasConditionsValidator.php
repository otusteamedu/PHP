<?php

namespace App\Validators;

use App\Log\Log;

class HasConditionsValidator extends Validator
{
    public function check ($event): bool
    {
        Log::getInstance()->addRecord('has conditions validation');

        if (!isset($event->conditions) || !is_array($event->conditions) || empty($event->conditions)) {
            Log::getInstance()->addRecord('error');

            return false;
        }

        Log::getInstance()->addRecord('success');

        return parent::check($event);
    }
}