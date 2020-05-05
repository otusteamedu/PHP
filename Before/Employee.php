<?php

class Employee
{
    private int $employee_id;
    private string $first_name;
    private string $second_name;
    private Post $post;
    private string $hire_date;

    /**
     * Employee constructor.
     * @param int $employee_id
     * @param string $first_name
     * @param string $second_name
     * @param Post $post
     * @param string $hire_date
     */

    public function __construct(int $employee_id, string $first_name, string $second_name, Post $post, string $hire_date)
    {
        $this->employee_id = $employee_id;
        $this->first_name = $first_name;
        $this->second_name = $second_name;
        $this->post = $post;
        $this->hire_date = $hire_date;
    }

    /**
     * @return int
     */
    public function getEmployeeId(): int
    {
        return $this->employee_id;
    }

    /**
     * @param int $employee_id
     */
    public function setEmployeeId(int $employee_id): void
    {
        $this->employee_id = $employee_id;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->first_name;
    }

    /**
     * @param string $first_name
     */
    public function setFirstName(string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string
     */
    public function getSecondName(): string
    {
        return $this->second_name;
    }

    /**
     * @param string $second_name
     */
    public function setSecondName(string $second_name): void
    {
        $this->second_name = $second_name;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    /**
     * @return string
     */
    public function getHireDate(): string
    {
        return $this->hire_date;
    }

    /**
     * @param string $hire_date
     */
    public function setHireDate(string $hire_date): void
    {
        $this->hire_date = $hire_date;
    }

    public function calculatePay($post) : float {
        $hourly_rate = ''; /*rate per hour in $ USA*/
        switch ($post) {
            case Post::worker: $hourly_rate = 8.5;
                break;
            case Post::hr_specialist: $hourly_rate = 9.5;
                break;
            case  Post::manager: $hourly_rate = 10;
                break;
            case Post::accountant: $hourly_rate = 10.25;
                break;
            case Post::developer: $hourly_rate = 15;
                break;
            case Post::director: $hourly_rate = 20;
                break;
        }
        return $hourly_rate*21.5*8; /*full month salary*/
    }

    public function reportHours() : int {
        return TimeSheet::setHoursWorked($this, 'March');
    }

    public function saveEmployee() {
        $db_host = "localhost";
        $db_user = "user";
        $db_password = "qwerty";
        $db = "base";
        $db_table = "Employees";
        $connection = mysqli_connect($db_host,$db_user,$db_password,$db);
        $sql = "INSERT INTO ".$db_table." (id, name, last name, post, hire date) VALUES
        (/*some values*/)";
        $result = mysqli_query($connection, $sql);
        mysqli_close($connection);
    }
}
