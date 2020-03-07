<?php

namespace Bjlag\Services;

use Symfony\Component\Routing\Exception\InvalidParameterException;

class CheckEmail
{
    /** @var array */
    private $mxhosts = [];

    /**
     * @param string $email
     * @return bool
     */
    public function check(string $email): bool
    {
        if (!$this->isEmailValid($email)) {
            throw new InvalidParameterException("Email {$email} имеет неверный формат");
        }

        $this->mxhosts = $this->getMx($this->getHost($email));

        return (count($this->mxhosts) === 0)
            ? false
            : true;
    }

    /**
     * @param string $email
     * @return bool
     */
    private function isEmailValid(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param string $email
     * @return string|null
     */
    private function getHost(string $email): ?string
    {
        $host = explode('@', $email);
        return $host[1] ?? null;
    }

    /**
     * @param string|null $host
     * @return array
     */
    private function getMx(?string $host): array
    {
        if ($host === null) {
            return [];
        }

        $mxhosts = [];
        getmxrr($host, $mxhosts);
        return $mxhosts;
    }

    /**
     * @return array
     */
    public function getMxhosts(): array
    {
        return $this->mxhosts;
    }
}
