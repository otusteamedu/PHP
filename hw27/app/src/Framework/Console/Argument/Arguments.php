<?php

declare(strict_types=1);

namespace App\Framework\Console\Argument;

use App\Framework\Console\ExpectedArgument\ExpectedArgument;
use App\Framework\Validator\Validator;
use App\Framework\Console\ExpectedArgument\ExpectedArgumentCollection;
use Exception;
use InvalidArgumentException;

class Arguments
{
    private ArgumentFactory            $argumentFactory;
    private ExpectedArgumentCollection $expectedArgumentCollection;

    public function __construct(
        ArgumentFactory $argumentFactory,
        ExpectedArgumentCollection $expectedArgumentCollection
    ) {
        $this->argumentFactory = $argumentFactory;
        $this->expectedArgumentCollection = $expectedArgumentCollection;
    }

    public function addExpectedArgument(ExpectedArgument $expectedArgument): void
    {
        $this->expectedArgumentCollection->add($expectedArgument);
    }

    /**
     * @throws Exception
     */
    public function getFirst(): ArgumentInterface
    {
        return $this->getByNumber(1);
    }

    /**
     * @throws Exception
     */
    public function getByName(string $argumentName): ArgumentInterface
    {
        $argumentNumber = $this->expectedArgumentCollection->get($argumentName)->getNumber();

        return $this->getByNumber($argumentNumber);
    }

    /**
     * @throws Exception
     */
    public function getByNumber(int $argumentNumber): ArgumentInterface
    {
        $argumentValue = !empty($_SERVER['argv'][$argumentNumber]) ? $_SERVER['argv'][$argumentNumber] : '';

        if ($expectedArgument = $this->expectedArgumentCollection->findByNumber($argumentNumber)) {
            $this->validation($argumentValue, $expectedArgument);

            return $this->argumentFactory->create(
                $expectedArgument->getType(),
                $expectedArgument->getName(),
                $argumentValue
            );
        }

        return $this->argumentFactory->create(
            ArgumentTypes::STRING,
            $argumentNumber,
            $argumentValue
        );
    }

    private function validation(string $argumentValue, ExpectedArgument $expectedArgument): void
    {
        if (!Validator::validate($argumentValue, $expectedArgument->getRules())) {
            throw new InvalidArgumentException(sprintf(Validator::getErrorMessage(), $expectedArgument->getName()));
        }
    }
}