<?php

namespace HW7_1;

class ListValidationWrapper extends AbstractBaseValidation
{
    /**
     * @var Validation
     */
    private $validation;


    /**
     * ListValidationWrapper constructor.
     * @param Validation $validation
     */
    public function __construct(Validation $validation)
    {
        $this->validation = $validation;
    }

    /**
     * @param string $emailsString list off emails separated with \r\n
     * @return bool TRUE if all of these valid, otherwise FALSE
     */
    public function validate(string $emailsString): bool
    {
        $emails = mb_split('\r\n', $emailsString);
        $checks = $this->validateArray($emails);
        $result = true;
        foreach ($checks as $email => $check) {
            $this->debug(sprintf('Validate result of %s: %b', $email, $check));
            $result = $result && $check;
        }
        return $result;
    }

    /**
     * @param string[] $emails array od strings with email
     * @return array associative array [ email => resultOfValidation ]
     */
    public function validateArray(array $emails): array
    {
        $results = [];
        foreach ($emails as $email) {
            $results[$email] = $this->validation->validate($email);
        }
        return $results;
    }
}
