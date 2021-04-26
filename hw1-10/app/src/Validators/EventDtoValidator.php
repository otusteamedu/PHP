<?php

namespace Src\Validators;

use Src\DTO\EventDto;
use Src\Messages\Responser;

/**
 * Class EventDtoValidator
 *
 * @package Src\Validators
 */
class EventDtoValidator
{
    /**
     * @param \Src\DTO\EventDto $eventDto
     *
     * @return bool
     * @throws \Exception
     */
    public static function isValidate(EventDto $eventDto): bool
    {
        return self::isValidEvent($eventDto->event) && self::isValidCondition($eventDto->conditions) && self::isValidPriority($eventDto->priority);
    }

    /**
     * @param $event
     *
     * @return bool
     * @throws \Exception
     */
    private static function isValidEvent($event): bool
    {
        if (empty($event) || !is_string($event) || $event === '') {
            Responser::responseFailData('event param ' . $event . ' is wrong');
        }
        return true;
    }

    /**
     * @param $conditions
     *
     * @return bool
     * @throws \Exception
     */
    private static function isValidCondition($conditions): bool
    {
        if (empty($conditions) || !is_array($conditions) || !isset($conditions)) {
            Responser::responseFailData('conditions param ' . $conditions . ' is wrong');
        }
        return true;
    }

    /**
     * @param $priority
     *
     * @return bool
     * @throws \Exception
     */
    private static function isValidPriority($priority): bool
    {
        if (empty($priority) || !is_int($priority) || $priority <= 0) {
            Responser::responseFailData('priority param ' . $priority . ' is wrong');
        }
        return true;
    }
}
