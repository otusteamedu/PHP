<?php
declare(strict_types=1);

namespace App\DTOs;

use App\Exceptions\FailToFetchCurrentRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Exceptions\InvalidDatesInBankStatementInput;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class BankStatementInputDTO implements DTOInterface
{
    /**
     * @var string
     */
    public string $from;

    /**
     * @var string
     */
    public string $to;

    /**
     * @var ?Request
     */
    private ?Request $request;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * BankStatementInputDTO constructor.
     *
     * @param RequestStack $requestStack
     * @param ValidatorInterface $validator
     */
    public function __construct(RequestStack $requestStack, ValidatorInterface $validator)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->validator = $validator;
    }

    /**
     * @return bool
     *
     * @throws FailToFetchCurrentRequest
     */
    public function validate(): bool
    {
        //$requestStack can return null
        if (!$this->request)
            throw new FailToFetchCurrentRequest();

        $data = [
            'from' => $this->request->get('from'),
            'to' => $this->request->get('to')
        ];

        $constraint = new Collection([
            'from' => new Date(message: 'Start date is invalid!'),
            'to' => new Date(message: 'End date is invalid!')
        ]);

        $groups = new GroupSequence(['Default', 'custom']);
        $errors = $this->validator->validate($data, $constraint, $groups);

        if (count($errors) === 0) {
            $this->from = $this->request->get('from');
            $this->to = $this->request->get('to');

            return true;
        }

        throw new InvalidDatesInBankStatementInput();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return "start date: {$this->from}, end date: {$this->to}";
    }
}
