<?php


namespace SysEvents;


class Event
{
    private $priority;
    private $id;
    private $content = '';

    /** @var Condition  */
    private $condition = null;

    public function __construct($priority, $eventData = [])
    {
        $this->priority = $priority;
        $this->id = $eventData['id'] ?? "no ID";
        $this->content = $eventData['content'] ?? '';
    }

    public static function create($priority, $eventData, $conditionData)
    {
        $inst = new self($priority, $eventData);

        $cond = new Condition($conditionData);
        $inst->setCondition($cond);
        return $inst;
    }


    public function setCondition($condition)
    {
        $this->condition = $condition;
    }

    public function getCondition()
    {
        return $this->condition;
    }

    public function getID()
    {
        return $this->id;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function toArray()
    {
        return ['id' => $this->getID(), 'content' => $this->getContent()];
    }



}