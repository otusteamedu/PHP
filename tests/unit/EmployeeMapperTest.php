<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use App\App;
use App\Domain\Employee;
use App\Domain\EmployeeMapper;
use Codeception\Test\Unit;

class EmployeeMapperTest extends Unit
{
    protected UnitTester $tester;

    public function testCRUD(): void
    {
        new App();
        $mapper = new EmployeeMapper(App::getPDO());

        $employee = (new Employee())
            ->setName('John')
            ->setSurname('Doe')
            ->setPhone('+79261234567')
            ->setJob('programmer')
            ->setSalary(100);
        $mapper->save($employee);
        $this->tester->seeInDatabase('employees', ['id' => $employee->getId()]);

        $employee->setName('Jane');
        $mapper->save($employee);
        $this->tester->seeInDatabase('employees', ['name' => 'Jane']);

        $mapper->delete($employee);
        $this->tester->seeNumRecords(0, 'employees', ['id' => $employee->getId()]);

        $this->assertEquals('dev', App::getEnv());
    }

    public function testFindById(): void
    {
        new App();
        $mapper = new EmployeeMapper(App::getPDO());

        $employee = (new Employee())
            ->setName('John')
            ->setSurname('Doe')
            ->setPhone('+79261234567')
            ->setJob('programmer')
            ->setSalary(100);
        $mapper->save($employee);

        $result = $mapper->findById($employee->getId());
        $this->assertEquals($employee, $result);
    }

    public function testFindByName(): void
    {
        new App();
        $mapper = new EmployeeMapper(App::getPDO());

        $employee = (new Employee())
            ->setName('John')
            ->setSurname('Doe')
            ->setPhone('+79261234567')
            ->setJob('programmer')
            ->setSalary(100);
        $mapper->save($employee);

        $employee = (new Employee())
            ->setName('Jane')
            ->setSurname('Doe')
            ->setPhone('+79261234567')
            ->setJob('programmer')
            ->setSalary(100);
        $mapper->save($employee);

        $employee = (new Employee())
            ->setName('John')
            ->setSurname('Smith')
            ->setPhone('+79261234567')
            ->setJob('programmer')
            ->setSalary(100);
        $mapper->save($employee);

        $result = $mapper->findByName('John');
        $this->assertCount(2, $result);
        $this->assertEquals('John', $result[0]->getName());
    }
}
