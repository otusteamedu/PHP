<?php

namespace App;

/**
 * Проверяет соответствие шаблону Email-адреса
 * @package App
 */
class RegexValidator implements EmailValidatorInterface
{
    const REGEX = '/.+@.+/';

    /**
     * @var string
     */
    private $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        return boolval(preg_match(self::REGEX, $this->email));
    }
}
