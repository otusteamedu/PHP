<?php

namespace App\Domain;

final class Employee
{
    private int $id = 0;
    private string $name;
    private string $surname;
    private string $phone;
    private string $job;
    private int $salary;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Employee
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Employee
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): Employee
    {
        $this->surname = $surname;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Employee
    {
        $this->phone = $phone;
        return $this;
    }

    public function getJob(): string
    {
        return $this->job;
    }

    public function setJob(string $job): Employee
    {
        $this->job = $job;
        return $this;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function setSalary(int $salary): Employee
    {
        $this->salary = $salary;
        return $this;
    }
}
