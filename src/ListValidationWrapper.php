<?php

namespace HW7_1;

use Psr\Log\LoggerInterface;
use function array_values;
use function explode;
use function sprintf;

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
        $emails = explode("\n", $emailsString);
        $checks = $this->validateArray($emails);
        $result = true;
        foreach (array_values($checks) as $check) {
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
            $check = $this->validation->validate($email);
            $this->debug(sprintf('Validate result of %s: %b', $email, $check));
            $results[$email] = $check;
        }
        return $results;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        parent::setLogger($logger);
        $this->validation->setLogger($logger);
    }
}
