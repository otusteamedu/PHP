<?php

namespace Validators\email;


class EmailValidator
{

    /**
     *
     * Get the validation of single email result
     *
     * @param string $email
     * @return bool
     */
    public function validate(string $email): bool
    {
        return $this->validateSingle($email);
    }

    /**
     *
     * Validates multiple emails
     *
     * @param array $emails
     * @return array
     */
    public function validateMultiple(array $emails): array
    {
        $res = [];
        foreach ($emails as $email)
            $res[$email] = $this->validateSingle($email);

        return $res;
    }

    /**
     *
     * Validation of single email
     *
     * @param string $email
     * @return bool
     */
    private function validateSingle(string $email): bool
    {
        return (bool)$this->validateInput($email) && $this->validateRegExp($email) && $this->validateMx($email);
    }

    /**
     *
     * Validates an input
     *
     * @param string $email
     * @return bool
     */
    private function validateInput(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     *
     * Validates email by regex
     *
     * @param string $email
     * @return bool
     */
    private function validateRegExp(string $email): bool
    {
        return preg_match('/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/', $email);
    }

    /**
     *
     * Validates mx records exists for email
     *
     * @param string $email
     * @return bool
     */
    private function validateMx(string $email): bool
    {
        $domain = substr($email, strpos($email, '@') + 1);
        if (getmxrr($domain, $mx_results)) {
            /* TODO: Investigate problem when getmxrr always returns true on docker container at local machine */
            return !empty($mx_results);
        }
        return false;
    }

}