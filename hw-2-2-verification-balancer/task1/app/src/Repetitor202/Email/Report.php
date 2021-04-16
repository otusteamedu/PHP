<?php


namespace Repetitor202\Email;


class Report
{
    /**
     * @param array $emails
     */
    public final function validateList(array $emails): void
    {
        foreach ($emails as $email) {
            $emailReport = $email;

            $emailReport .= ' email:';
            if ((new Validator())->validateEmail($email)) {
                $emailReport .= 'valid';
            } else {
                $emailReport .= 'invalid';
            }

            $emailPieces = explode('@', $email);
            $hostname = $emailPieces[1];

            $emailReport .= ' host:';
            if ((new Validator())->validateHostname($hostname)) {
                $emailReport .= 'valid';
            } else {
                $emailReport .= 'invalid';
            }

            echo $emailReport . PHP_EOL;
        }
    }
}