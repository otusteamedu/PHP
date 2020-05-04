<?php


namespace Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    const VIOLATION = '';

    /** @var array */
    protected $request;

    /** @var array */
    protected $headers;

    /**
     * AbstractValidator constructor.
     * @param array $request
     * @param $headers
     */
    public function __construct(array $request, $headers)
    {
        $this->request = $request;
        $this->headers = $headers ?: [];
    }

    /** @inheritDoc */
    public abstract function validate();

    /**
     * @return string
     */
    public function getViolation()
    {
        return static::VIOLATION;
    }
}
