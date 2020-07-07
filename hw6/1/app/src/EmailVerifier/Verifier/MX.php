<?php
declare(strict_types=1);

namespace EmailVerifier\Verifier;

use EmailVerifier\EmailVerifierException;

class MX implements VerifierInterface
{
    /**
     * @throws EmailVerifierException
     */
    public function verify(string $email): void
    {
        $domainPartOfEmail = strrchr($email, "@");
        $hostname = substr($domainPartOfEmail ?: $email, 1);
        $result = getmxrr($hostname, $mxhosts, $weight);

        if (
            $result === false || self::checkMXHosts($mxhosts)
        ) {
            throw new EmailVerifierException(
                'Не найдена корректная MX-запись для домена ' . $hostname
            );
        }
    }

    private static function checkMXHosts(array $mxhosts): bool
    {
        return
            count($mxhosts) === 0 ||
            (
                count($mxhosts) === 1 &&
                (
                    $mxhosts[0] == null ||
                    $mxhosts[0] == "0.0.0.0"
                )
            );
    }
}