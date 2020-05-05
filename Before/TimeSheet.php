<?php


class TimeSheet
{
    private array $employees;

    /**
     * TimeSheet constructor.
     * @param array $employees
     */
    public function __construct(array $employees)
    {
        $this->$employees = $employees;
    }

    public function getEmployeeById(int $employee_id) : Employee {
        foreach ($this->employees as $employee) {
            if ($employee->getEmployeeId() == $employee_id) {return $employee;}
        }
        return null;
    }
    public static function setHoursWorked(Employee $employee, string $month) : int {
        return rand(1, 170);
    }
}