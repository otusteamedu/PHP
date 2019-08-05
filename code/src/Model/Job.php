<?php

namespace crazydope\theater\Model;

class Job implements JobInterface
{
    /**
     * @var string|null
     */
    protected $value;

    public function __construct(?string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string|null
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}