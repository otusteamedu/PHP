<?php

namespace nvggit;

/**
 * Class Calculator
 * @package nvggit
 */
class Calculator
{
    /**
     * @param $operation
     * @param float $a
     * @param float $b
     * @return float
     * @throws \Exception
     */
    public function exec($operation, float $a, float $b): float
    {
        if ($this->canPerformOperation($operation))
            return $this->getOperations()[$operation]->exec($a, $b);
        throw new \Exception("The operation is not supported!");
    }

    public function getOperations(): array
    {
        return [
            'add' => new Add(),
            'sub' => new Substract(),
            'mul' => new Multiply(),
            'div' => new Divide()
        ];
    }

    public function canPerformOperation(string $operation): bool
    {
        return array_key_exists($operation, $this->getOperations());
    }
}