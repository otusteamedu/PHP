<?php
declare(strict_types=1);


class Event
{
    /** @var string */
    private $name;
    
    /** @var int */
    private $priority;
    
    /** @var string */
    private $parameter1;

    /** @var string */
    private $parameter2;
    
    public function __construct(string $name, int $priority, string $parameter1, string $parameter2)
    {
        $this->name = $name;
        $this->priority = $priority;
        $this->parameter1 = $parameter1;
        $this->parameter2 = $parameter2;
    }
    
    public function getName(): string 
    {
        return $this->name;
    }
    
    public function getPriority(): int 
    {
        return $this->priority;
    }
    
    public function getParameter1(): string 
    {
        return $this->parameter1;
    }

    public function getParameter2(): string
    {
        return $this->parameter2;
    }

}