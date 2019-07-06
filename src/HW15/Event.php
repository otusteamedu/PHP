<?php

namespace HW15;

use stdClass;

class Event
{
    /** @var int */
    public $priority;
    /** @var array */
    public $conditions;
    /** @var stdClass */
    public $event;

    public function __toString()
    {
        return sprintf('%s with %d priority and conditions: %s', $this->event->title, $this->priority, EventProvider::buildKeyByConditions($this->conditions));
    }
}