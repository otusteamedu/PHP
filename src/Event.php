<?php

namespace crazydope\events;

class Event implements EventInterface
{
    /**
     * @var null|int
     */
    protected $id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $description = '';

    protected static function objectToEvent(\stdClass $object): EventInterface
    {
        $event = new Event();
        $event
            ->setName($object->name)
            ->setDescription($object->description);

        if (isset($object->id)) {
            $event->setId($object->id);
        }
        return $event;
    }

    /**
     * @param string|\stdClass $json
     * @return EventInterface
     */
    public static function jsonDeserialize($json): EventInterface
    {
        if (is_string($json)) {
            $json = \json_decode($json);
        }

        return self::objectToEvent($json);
    }

    /**
     * Event constructor.
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name = '', string $description = '')
    {
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return EventInterface
     */
    public function setName(string $name): EventInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return EventInterface
     */
    public function setDescription(string $description): EventInterface
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return EventInterface
     */
    public function setId(int $id): EventInterface
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description
        ];
    }
}