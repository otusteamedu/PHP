<?php

namespace Classes\Dto;

/**
 * @property string $eventName
 * @property integer $eventPriority
 * @property array $eventCriterions
 */

class EventDto
{
    public $eventName;
    public $eventPriority;
    public $eventCriterions;

    public static function build(EventDtoBuilder $builder)
    {
        $self = new self();
        $self->eventName = $builder->getEventName();
        $self->eventPriority = $builder->getEventPriority();
        $self->eventCriterions = $builder->getEventCriterions();

        return $self;
    }

}
