<?php

namespace crazydope\calculator\tests;

use crazydope\calculator\ExecCommand;
use crazydope\calculator\Exceptions\InvalidInputException;
use crazydope\calculator\Exceptions\DivisionByZeroException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ExecCommandTest extends TestCase
{
    /**
     * @var CommandTester
     */
    protected $commandTester;

    protected function setUp()
    {
        $application = new Application();
        $application->add(new ExecCommand());
        $command = $application->find('exec');
        $this->commandTester = new CommandTester($command);
    }

    protected function tearDown()
    {
        $this->commandTester = null;
    }

    public function testExecuteShouldThrowInvalidInputException(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->commandTester->execute([
            'command'=>$this->getName(),
            'data'=>['1','+']
        ]);
    }

    public function testExecuteShouldThrowInvalidInputExceptionAgain(): void
    {
        $this->expectException(InvalidInputException::class);
        $this->commandTester->execute([
            'command'=>$this->getName(),
            'data'=>['1','+','2','-']
        ]);
    }

    public function testExecuteShouldThrowDivisionByZeroException(): void
    {
        $this->expectException(DivisionByZeroException::class);
        $this->commandTester->execute([
            'command'=>$this->getName(),
            'data'=>['1','/','0']
        ]);
    }

    public function testExecute(): void
    {
        $this->commandTester->execute(['command'=>$this->getName(),'data'=>[
            '3','+', '2', '*', '5', '+', '10', '/', '2', '-', '8'
        ]]);
        $this->assertEquals('Результат: 10', $this->commandTester->getDisplay());
    }
    
}