<?php


class EmployeeSaver
{
    /**
     * EmployeeSaver constructor.
     * @param EmployeeData $employee
     */
    public function __construct(EmployeeData $employee)
    {
        /*just for example*/
        $this->$employee = new EmployeeData(1, 2020-01-30, Post::developer,'Vasya','Pupkin');
        $salary = PayCalculator::calculatePay(Post::developer);
        $hours_worked = HourReporter::reportHours();
    }

    public function saveEmployee() {
        $db_host = "localhost";
        $db_user = "user";
        $db_password = "qwerty";
        $db = "base";
        $db_table = "Employees";
        $connection = mysqli_connect($db_host,$db_user,$db_password,$db);
        $sql = "INSERT INTO ".$db_table." (id, name, last name, post, hire date) VALUES
        (1, 'Vasya','Pupkin', developer, 2020-01-30)";
        $result = mysqli_query($connection, $sql);
        mysqli_close($connection);
    }
}