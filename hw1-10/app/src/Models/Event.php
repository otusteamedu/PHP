<?php
namespace Src\Models;

use Src\DTO\EventDto;

/**
 * Class Event
 */
class Event
{
    private EventDto $eventDTO;

    public function __construct(EventDto $eventDTO)
    {
        $this->eventDTO = $eventDTO;
    }

    /**
     * Encoding DTO to JSON
     */
    public function toJson(): string
    {
        return \GuzzleHttp\json_encode(
            [
                'uid' => $this->eventDTO->getUid(),
                'priority' => $this->eventDTO->getPriority(),
                'conditions' => $this->eventDTO->getConditions(),
                'event' => $this->eventDTO->getEvent(),
            ]
        );
    }

    public function getConditionsStrings(): array
    {
        $result = [];

        foreach ($this->eventDTO->getConditions() as $key => $value) {
            $result[] = Condition::getConditionString($key, $value);
        }

        return $result;
    }
}