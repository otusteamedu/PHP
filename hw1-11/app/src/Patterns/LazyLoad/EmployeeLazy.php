<?php

namespace Src\Patterns\LazyLoad;

use Src\Patterns\ActiveRecord\Employee;

class EmployeeLazy
{
    private $emloyee = [];

    /**
     * @param $pdo
     * @param $id
     *
     * @return mixed|Employee
     */
    public function getEmployee($pdo, $id)
    {
        if (!isset($this->emloyee[$id])) {
            $this->emloyee[$id] = Employee::getById($pdo, $id);
        }

        return $this->emloyee[$id];
    }
}