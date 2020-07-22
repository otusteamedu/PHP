<?php

namespace Classes\Dto;

class EventDtoBuilder
{
    private $errors;

    private $eventName;
    private $eventPriority;
    private $eventCriterions = [];

    public function setEventName(?string $eventName)
    {
        $this->eventName = $eventName;
        return $this;
    }

    public function setEventPriority(?int $eventPriority)
    {
        $this->eventPriority = $eventPriority;
        return $this;
    }

    public function setEventCriterions (array $eventCriterions)
    {
        $this->eventCriterions = $eventCriterions;
        return $this;
    }


    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
        }
        return EventDto::build($this);
    }

    public function validate()
    {
        if (empty($this->eventCriterions)) {
            $this->errors[] = 'Не заданы критерии возникновения события';
        }

    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function getEventPriority()
    {
        return $this->eventPriority;
    }

    public function getEventCriterions()
    {
        return $this->eventCriterions;
    }
}
