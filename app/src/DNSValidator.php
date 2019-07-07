<?php

namespace App;

/**
 * Проверяет сущестование MX-записи в DNS у хоста, указанного
 * в Email-адресе
 * @package App
 */
class DNSValidator implements EmailValidatorInterface
{
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
        $email = $this->email;
        $emailParts = explode('@', $email);
        if (count($emailParts) !== 2) {
            return false;
        }
        $mxHosts = [];
        $result = getmxrr($emailParts[1], $mxHosts);
        return $result && count($mxHosts) > 0;
    }
}
