<?php

namespace App\Domain;

use PDO;

final class EmployeeMapper
{
    private const Q_BASE_SELECT = 'select id, name, surname, phone, job, salary from employees ';

    private PDO $pdo;

    /**
     * @var Employee[]
     */
    private static array $map = [];

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function delete(Employee $employee): void
    {
        $q = 'delete from employees where id = :id';
        $this->pdo
            ->prepare($q)
            ->execute(['id' => $employee->getId()]);
        unset(self::$map[$employee->getId()]);
    }

    public function save(Employee $employee): void
    {
        if (0 === $employee->getId()) {
            $this->insert($employee);
        }
        $this->update($employee);
        self::$map[$employee->getId()] = $employee;
    }

    private function insert(Employee $employee): void
    {
        $q = '
            insert into employees (name, surname, phone, job, salary)
            values (:name, :surname, :phone, :job, :salary)
            returning id
        ';
        $s = $this->pdo->prepare($q);
        $s->execute(
            [
                'name' => $employee->getName(),
                'surname' => $employee->getSurname(),
                'phone' => $employee->getPhone(),
                'job' => $employee->getJob(),
                'salary' => $employee->getSalary(),
            ]
        );
        $id = $s->fetch(PDO::FETCH_COLUMN);
        $employee->setId($id);
    }

    private function update(Employee $employee): void
    {
        $q = '
            update employees
            set
                name = :name,
                surname = :surname,
                phone = :phone,
                job = :job,
                salary = :salary
            where id = :id
        ';
        $this->pdo
            ->prepare($q)
            ->execute(
                [
                    'id' => $employee->getId(),
                    'name' => $employee->getName(),
                    'surname' => $employee->getSurname(),
                    'phone' => $employee->getPhone(),
                    'job' => $employee->getJob(),
                    'salary' => $employee->getSalary(),
                ]
            );
    }

    public function findById(int $id): ?Employee
    {
        if (isset(self::$map[$id])) {
            return self::$map[$id];
        }
        $s = $this->pdo->prepare(self::Q_BASE_SELECT . 'where id = ?');
        $s->execute([$id]);
        self::$map[$id] = $s->rowCount() ? $s->fetchObject(Employee::class) : null;
        return self::$map[$id];
    }

    /**
     * @param string $name
     * @return Employee[]
     */
    public function findByName(string $name): array
    {
        $s = $this->pdo->prepare(self::Q_BASE_SELECT . 'where name = ?');
        $s->execute([$name]);
        $result = $s->rowCount() ? $s->fetchAll(PDO::FETCH_CLASS, Employee::class) : [];
        foreach ($result as $employee) {
            self::$map[$employee->getId()] = $employee;
        }
        return $result;
    }
}
