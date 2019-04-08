<?php

namespace HW7_1;

use InvalidArgumentException;
use function get_class;
use function sprintf;

/**
 * Uses for several validation
 *
 * Class ComplexValidator
 * @package HW7_1
 */
class ComplexValidation extends AbstractBaseValidation
{
    /**
     * @var Validation[]
     */
    private $validations;

    /**
     * ComplexValidator constructor.
     * @param array $validations
     */
    public function __construct(array $validations = [])
    {
        foreach ($validations as $validation) {
            if ($validation instanceof Validation) {
                $this->addValidation($validation);
            } else {
                $this->error(sprintf('Argument is not Validation'), ['arg' => $validation]);
                throw new InvalidArgumentException('Argument is not Validation');
            }
        }
    }

    /**
     * Add validator for check
     *
     * @param Validation $validation
     */
    public function addValidation(Validation $validation): void
    {
        $this->debug(sprintf('Add validator %s', get_class($validation)));
        $this->validations[] = $validation;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        $this->debug(sprintf('Check email with %s, %s', get_class($this), $email));
        $result = true;
        /** @var Validation $validation */
        foreach ($this->validations as $validation) {
            $result = $result && $validation->validate($email);
        }
        $this->debug(sprintf('Check result for email %s: %b', $email, $result));
        return $result;
    }
}
