<?php

namespace Bjlag\Controllers;

use Bjlag\Services\CheckEmail;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class CheckEmailController
{
    /** @var \Bjlag\Services\CheckEmail */
    private $serviceCheckEmail;

    public function __construct()
    {
        $this->serviceCheckEmail = new CheckEmail();
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param array $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $email = $this->getEmail($args);

        if (!$this->serviceCheckEmail->check($email)) {
            throw new InvalidParameterException("Email {$email} некорректный<br>MX запись не найдена.");
        }

        $message = "Email {$email} корректный<br>";
        $message .= 'MX запись: ' . implode(', ', $this->serviceCheckEmail->getMxhosts());

        return (new \Bjlag\Response(200, [], $message))
            ->withServerName($request)
            ->get();
    }

    /**
     * @param array $args
     * @return string
     */
    private function getEmail(array $args): string
    {
        $email = $args['email'] ?? null;
        if (empty($email)) {
            throw new InvalidParameterException('Емейл не найден.');
        }

        return $email;
    }
}
