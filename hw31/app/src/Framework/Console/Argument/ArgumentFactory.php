<?php

declare(strict_types=1);

namespace App\Framework\Console\Argument;

use Exception;
use UnexpectedValueException;

class ArgumentFactory
{
    /**
     * @throws Exception
     */
    public function create(int $argumentType, $argumentNameOrNumber, string $argumentValue): ArgumentInterface
    {
        switch ($argumentType) {
            case ArgumentTypes::STRING:
                return new StringArgument($argumentNameOrNumber, $argumentValue);
            case ArgumentTypes::INTEGER:
                return new IntegerArgument($argumentNameOrNumber, $argumentValue);
            case ArgumentTypes::DATE:
                return new DateArgument($argumentNameOrNumber, $argumentValue);
            case ArgumentTypes::ARRAY:
                return new ArrayArgument($argumentNameOrNumber, $argumentValue);
            default:
                throw new UnexpectedValueException('Неизвестный тип аргумента');
        }
    }
}