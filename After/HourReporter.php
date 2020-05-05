<?php


class HourReporter
{
private EmployeeData $employee;

    /**
     * HourReporter constructor.
     * @param EmployeeData $employee
     */
    public function __construct(EmployeeData $employee)
    {
        $this->employee = $employee;
    }

    public static function reportHours() : int {
        return rand(1, 168);
    }
}