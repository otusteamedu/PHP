<?php


abstract class AbstractValidator implements ValidatorInterface
{
    /** @var string */
    protected $email;

    /**
     * AbstractValidator constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    abstract public function validate();
}
