<?php

namespace crazydope\calculator;

use crazydope\calculator\Exceptions\DivisionByZeroException;
use crazydope\calculator\Exceptions\InvalidInputException;
use crazydope\calculator\Exceptions\EmptyDataException;
use crazydope\calculator\Exceptions\InvalidOperationException;
use crazydope\calculator\Exceptions\NotEnoughArgumentsException;
use crazydope\calculator\Exceptions\NotExpression;
use crazydope\calculator\Exceptions\NotNumberException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecCommand
    extends Command
{
    protected const OPERATIONS = ['+', '-', '*', '/'];

    protected const EMPTY_DATA = 0;

    protected const MIN_ARGUMENTS = 3;

    protected const BASIC_PRIORITY = 1;

    protected const FIRST_PRIORITY = 2;

    protected $apex = [];

    /**
     * @param array $data
     * @param InvalidInputException $errors
     * @throws InvalidInputException
     */
    protected function inputValidate( array $data, InvalidInputException $errors ): void
    {
        $countData = count($data);

        if ( $countData === self::EMPTY_DATA ) {
            $errors->add(new EmptyDataException('Вы ничего не передали :('));
        }

        if ( ($countData > self::EMPTY_DATA && $countData < self::MIN_ARGUMENTS ) && $errors->isEmpty() ) {
            $errors->add(new NotEnoughArgumentsException('Недостаточно аргументов :('));
        }

        if ( !( $countData % 2 ) && $errors->isEmpty() ) {
            $errors->add(new NotEnoughArgumentsException('Недостаточно аргументов :('));
        }

        foreach ( $data as $key => $val ) {

            if ( $key % 2 ) {
                if ( !in_array($val, self::OPERATIONS, false) ) {
                    $errors->add(new InvalidOperationException("Операция '$val' не определена"));
                }

                if ( $val === '*' || $val === '/' ) {
                    array_unshift($this->apex, $key);
                }

                if ( $val === '+' || $val === '-' ) {
                    $this->apex[] = $key;
                }
            }

            if ( !( $key % 2 ) && !is_numeric($val) ) {
                $errors->add(new NotNumberException("'$val' не является числом"));
            }
        }

        if ( !$errors->isEmpty() ) {
            throw $errors;
        }
    }

    protected function configure(): void
    {
        $this
            ->setName('exec')
            ->setDescription('Операции над числами')
            ->addArgument('data', InputArgument::IS_ARRAY);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     * @throws DivisionByZeroException
     * @throws InvalidInputException
     * @throws NotExpression
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $data = $input->getArgument('data');
        $errors = new InvalidInputException("Ошибка ввода: \n");

        $this->inputValidate($data, $errors);
        $list = new ExpressionList();

        while ( $this->apex ) {
            $idx = array_shift($this->apex);
            $list->add(new Expression($idx - 1, $idx + 1, $data[$idx]));
        }

        $strategy = new CalendarStrategyContext($data, $list);
        $result = $strategy->calculate();

        $output->write('Результат: ' . $result);
    }
}