<?php

namespace App\ModelHydrators;

use App\Models\Event;

class RedisEventModelHydrator extends AbstractRedisHydrator
{
    protected const MAPPING = [
        'setId' => 'id',
        'setPriority' => 'priority',
        'setName' => 'event',
        'setConditions' => 'conditions'
    ];

    /**
     * @var Event
     */
    public Event $model;

    /**
     * RequestEventModelHydrator constructor.
     *
     * @param Event $model
     */
    public function __construct(Event $model)
    {
        $this->model = $model;
    }
}
