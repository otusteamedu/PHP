<?php


class Person
{
protected string $first_name;
protected string $second_name;

    /**
     * Person constructor.
     * @param string $first_name
     * @param string $second_name
     */
    public function __construct(string $first_name, string $second_name)
    {
        $this->first_name = $first_name;
        $this->second_name = $second_name;
    }

}