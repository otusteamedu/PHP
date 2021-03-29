<?php


namespace App\Model\Builders;


use App\Model\Event;
use App\Model\Exceptions\EventBuilderInvalidArgumentException;
use \Exception;

class EventBuilder
{

    public function build(array $event): Event
    {
        $model = new Event();

        try {
            $model->setId($event['id']);
            $model->setPriority($event['priority']);

            $param1 = isset($event['param1']) ? ['param1' => $event['param1']] : [];
            $param2 = isset($event['param2']) ? ['param2' => $event['param2']] : [];

            $model->setCondition(array_merge($param1, $param2));
            $model->setEvent($event['event']);

        } catch (Exception $e) {
            throw new EventBuilderInvalidArgumentException('Invalid data');
        }

        return $model;
    }
}
