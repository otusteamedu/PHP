<?php
declare(strict_types=1);

namespace BracketValidator;

use BracketValidator\Validator\ValidatorInterface;

class BracketValidator
{
    const ALLOWED_SYMBOLS = '()';

    /**
     * @var ValidatorInterface[]
     */
    private array $validators = [];

    public function run(?string $str): array
    {
        if (empty($str)) {
            return [
                'Отсутствует строка для проверки',
            ];
        }

        $errors = [];

        foreach ($this->getValidators() as $validator) {
            try {
                $validator->validate($str);
            } catch (BracketValidatorException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @return ValidatorInterface[]
     */
    public function getValidators(): array
    {
        return $this->validators;
    }

    public function addValidator(ValidatorInterface $validator): self
    {
        $this->validators[get_class($validator)] = $validator;

        return $this;
    }
}