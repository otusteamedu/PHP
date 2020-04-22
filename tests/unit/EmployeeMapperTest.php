<?php

/** @noinspection PhpIllegalPsrClassPathInspection */

use App\App;
use App\Domain\Employee;
use App\Domain\EmployeeMapper;
use Codeception\Test\Unit;

class EmployeeMapperTest extends Unit
{
    protected UnitTester $tester;

    protected static function newEmployee(): Employee
    {
        $faker = Faker\Factory::create('ru_RU');
        return (new Employee())
            ->setName($faker->firstName)
            ->setSurname($faker->lastName)
            ->setPhone($faker->e164PhoneNumber)
            ->setJob($faker->word)
            ->setSalary($faker->randomNumber());
    }

    public function testCRUD(): void
    {
        new App();
        $mapper = new EmployeeMapper(App::getPDO());

        $employee = static::newEmployee();
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

        $employee = static::newEmployee();
        $mapper->save($employee);

        $result = $mapper->findById($employee->getId());
        $this->assertEquals($employee, $result);
    }

    public function testFindByName(): void
    {
        new App();
        $mapper = new EmployeeMapper(App::getPDO());

        $employee = static::newEmployee()->setName('John');
        $mapper->save($employee);

        $employee = static::newEmployee()->setName('John');
        $mapper->save($employee);

        $employee = static::newEmployee()->setName('Jane');
        $mapper->save($employee);

        $result = $mapper->findByName('John');
        $this->assertCount(2, $result);
        $this->assertEquals('John', $result[0]->getName());
    }
}
