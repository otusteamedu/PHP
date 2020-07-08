<?php
declare(strict_types=1);

namespace EmailVerifier;

use EmailVerifier\Verifier\VerifierInterface;

class EmailVerifier
{
    /**
     * @var VerifierInterface[]
     */
    private array $verifiers = [];

    public function run(?string $email): array
    {
        if (empty($email)) {
            return [
                'Отсутствует email для проверки',
            ];
        }

        $errors = [];

        foreach ($this->getVerifiers() as $verifier) {
            try {
                $verifier->verify($email);
            } catch (EmailVerifierException $e) {
                $errors[] = $e->getMessage();
            }
        }

        return $errors;
    }

    /**
     * @return VerifierInterface[]
     */
    public function getVerifiers(): array
    {
        return $this->verifiers;
    }

    public function addVerifier(VerifierInterface $verifier): self
    {
        $this->verifiers[get_class($verifier)] = $verifier;

        return $this;
    }
}