<?php

namespace App\Validators;

use App\Log\Log;

class HasEventValidator extends Validator
{
    public function check ($event): bool
    {
        Log::getInstance()->addRecord('has event validation');

        if (!isset($event->event) || !is_string($event->event) || $event->event === '') {
            Log::getInstance()->addRecord('error');

            return false;
        }

        Log::getInstance()->addRecord('success');

        return parent::check($event);
    }
}