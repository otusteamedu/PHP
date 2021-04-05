<?php

namespace App\Validators;

use App\Models\DTO\EventDTO;

class EventDTOValidator
{
    public static function validate(EventDTO $event)
    {
        $validator = new HasIdValidator();
        $validator->linkWith(new HasPriorityValidator())
            ->linkWith(new HasConditionsValidator())
            ->linkWith(new HasEventValidator());

        return $validator->check($event);
    }
}