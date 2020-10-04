<?php

declare(strict_types=1);

namespace EntityMapper;

use Entity\Employee;
use PDO;
use PDOStatement;

class EmployeeMapper
{

    private PDO $pdo;
    private PDOStatement $selectAll;
    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;

    /**
     * EmployeeMapper constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->selectAll = $pdo->prepare(
            "select id, name, surname, phone, company, job, salary from employees"
        );
        $this->selectStmt = $pdo->prepare(
            "select name, surname, phone, company, job, salary from employees where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into employees (name, surname, phone, company, job, salary) values (?, ?, ?, ?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update employees set name = ?, surname = ?, phone = ?, company = ?, job = ?, salary = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from employees where id = ?");
    }


    public function getAllEmployee(): array
    {
        $this->selectAll->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectAll->execute();
        $employers = $this->selectAll->fetchAll();
        $arrEmployerObj = [];

        foreach ($employers as $employer) {
            $arrEmployerObj[] = (new Employee())
                ->setId((int)$employer['id'])
                ->setName($employer['name'])
                ->setSurname($employer['surname'])
                ->setCompany($employer['company'])
                ->setJob($employer['job'])
                ->setPhone($employer['phone'])
                ->setSalary((float)$employer['salary']);
        }

        return $arrEmployerObj;
    }

    /**
     * @param int $id
     * @return Employee
     */
    public function findById(int $id): Employee
    {
        $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return (new Employee())
            ->setId($id)
            ->setName($result['name'])
            ->setSurname($result['surname'])
            ->setCompany($result['company'])
            ->setJob($result['job'])
            ->setPhone($result['phone'])
            ->setSalary((float)$result['salary']);
    }

    /**
     * @param array $raw
     * @return Employee
     */
    public function insert(array $raw): Employee
    {
        $this->insertStmt->execute([
            $raw['name'],
            $raw['surname'],
            $raw['phone'],
            $raw['company'],
            $raw['job'],
            $raw['salary'],
        ]);

        return (new Employee())
            ->setId((int)$this->pdo->lastInsertId())
            ->setName($raw['name'])
            ->setSurname($raw['surname'])
            ->setCompany($raw['company'])
            ->setJob($raw['job'])
            ->setPhone($raw['phone'])
            ->setSalary((float)$raw['salary']);
    }

    /**
     * @param Employee $employee
     * @return bool
     */
    public function update(Employee $employee): bool
    {
        return $this->updateStmt->execute([
            $employee->getName(),
            $employee->getSurname(),
            $employee->getPhone(),
            $employee->getCompany(),
            $employee->getJob(),
            $employee->getSalary(),
            $employee->getId(),
        ]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->deleteStmt->execute([$id]);
    }
}