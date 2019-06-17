<?php

namespace App;

use App\Calculator\{AdditionOperation, Calculator, DivisionOperation, MultiplicationOperation, SubtractionOperation};
use App\Exception\ApplicationException;
use App\Exception\ArgumentException;
use App\Exception\InputException;

require_once 'vendor/autoload.php';

function help()
{
    echo <<<DOC
Simple calculator. Performs simple mathematical operations on two numbers.
Supported operations: addition (+), subtraction (-), multiplication (*), division(/).

Usage: php calculator.php < ARG1 > < OPERATOR > < ARG2 >

To input negative number, prefix argument with "-"
Arguments can also be float values.

Examples:
php calculator.php 1 + 1
php calculator.php -8.0 + 15.0
php calculator.php 9 - -1
php calculator.php 7 * 10
php calculator.php 10 / 2

DOC;
}

try {
    try {
        $options = getopt('h', ['help']);
        if (array_intersect(['h', 'help'], array_keys($options))) {
            help();
            exit;
        }
        if ($argc != 4) {
            throw new InputException(sprintf(
                "Invalid argument count: %d." . PHP_EOL .
                "3 arguments must be passed", $argc
            ), $argc - 1); // вычитаем 1 так как первый аргумент - имя файла скрипта
        }

        // Проверка что аргументы являются числами
        $inputValueArgvIndexes = [1, 3];
        array_walk($inputValueArgvIndexes, function($index) use ($argv) {
            if (!is_numeric($argv[$index])) {
                throw new ArgumentException(sprintf("Argument is not a numeric value: %s", $argv[$index]));
            }
        });

        $inputA = floatval($argv[1]);
        $inputB = floatval($argv[3]);
        $inputOperation = $argv[2];

        switch ($inputOperation) {
            case '+':
                $operation = new AdditionOperation();
                break;
            case '-':
                $operation = new SubtractionOperation();
                break;
            case '*':
                $operation = new MultiplicationOperation();
                break;
            case '/':
                $operation = new DivisionOperation();
                break;
            default:
                throw new InputException(sprintf("Operation not supported: %s", $inputOperation));
        }

        $calculator = new Calculator($operation);
        $result = $calculator->calculate($inputA, $inputB);
        echo $result . PHP_EOL;

    } catch (ApplicationException $e) {
        $message = $e->getMessage() . PHP_EOL .
            PHP_EOL .
            "Use -h, --help to see examples.";
        throw new \Exception($message, 0, $e);
    }
} catch (\Exception $e) {
    $message = !is_null($e->getPrevious()) && $e->getPrevious() instanceof ApplicationException ?
        $e->getMessage() : "Unexpected error";
    fwrite(STDERR, "Error: " . $message . PHP_EOL);
    exit(1);
}
