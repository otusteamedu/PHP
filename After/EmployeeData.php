<?php


class EmployeeData extends Person
{
    private int $id;
    private string $hire_date;
    private int $post;

    /**
     * EmployeeData constructor.
     * @param int $id
     * @param string $hire_date
     * @param int $post
     * @param string $first_name
     * @param string $second_name
     */
    public function __construct(int $id, string $hire_date, int $post, string $first_name, string $second_name)
    {
        parent::__construct($first_name, $second_name);
        $this->id = $id;
        $this->hire_date = $hire_date;
        $this->post = $post;
    }

}
