<?php

namespace App\Model;

use App\Api\ValidatorInterface;

class EmailCompositeValidator implements ValidatorInterface
{
    /** @var ValidatorInterface[]  */
    private array $validators = [];

    /**
     * @param string $input
     * @return bool
     */
    public function validate($input): bool
    {
        foreach ($this->validators as $validator) {
            if (!$validator->validate($input)) {
                return false;
            }
        }
        return true;
    }

    public function addValidator(ValidatorInterface $validator): self
    {
        $this->validators[] = $validator;
        return $this;
    }

}