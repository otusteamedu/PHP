<?php

namespace App\Form;

use Laminas\Validator;
use Psr\Http\Message\ServerRequestInterface;

class PayCardForm
{
    public const CARD_NUMBER = 'card_number';
    public const CARD_HOLDER = 'card_holder';
    public const CARD_EXPIRATION = 'card_expiration';
    public const CVV = 'cvv';
    public const ORDER_NUMBER = 'order_number';
    public const SUM = 'sum';

    /** @var array */
    private $errors = [];

    /** @var string */
    private $cardNumber;

    /** @var string */
    private $cardHolder;

    /** @var string */
    private $cardExpiration;

    /** @var string */
    private $cvv;

    /** @var string */
    private $orderNumber;

    /** @var float */
    private $sum;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     */
    public function __construct(ServerRequestInterface $request)
    {
        $data = $request->getParsedBody();

        $this->cardNumber = $data[self::CARD_NUMBER] ?? '';
        $this->cardHolder = $data[self::CARD_HOLDER] ?? '';
        $this->cardExpiration = $data[self::CARD_EXPIRATION] ?? '';
        $this->cvv = $data[self::CVV] ?? '';
        $this->orderNumber = $data[self::ORDER_NUMBER] ?? '';
        $this->sum = $data[self::SUM] ?? '';
    }

    /**
     * @return bool
     */
    public function isValidate(): bool
    {
        $this->validateCardNumber($this->cardNumber);
        $this->validateCardHolder($this->cardHolder);
        $this->validateCardExpiration($this->cardExpiration);
        $this->validateCvv($this->cvv);
        $this->validateOrderNumber($this->orderNumber);
        $this->validateSum($this->sum);

        return !$this->hasErrors();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @param string $value
     */
    private function validateCardNumber(string $value): void
    {
        $validator = new Validator\Regex(['pattern' => '/^\d{16}$/']);
        $validator->setMessage('Card number should consist of 16 digits', Validator\Regex::NOT_MATCH);

        if (!$validator->isValid($value)) {
            $this->errors[self::CARD_NUMBER] = $this->collectErrors($validator);
        }
    }

    /**
     * @param string $value
     */
    private function validateCardHolder(string $value): void
    {
        $validator = new Validator\Regex(['pattern' => '/^[a-zA-Z\-]+ [a-zA-Z\-]+$/']);
        $validator->setMessage('Card holder should consist of Latin letters and dash');

        if (!$validator->isValid($value)) {
            $this->errors[self::CARD_HOLDER] = $this->collectErrors($validator);
        }
    }

    /**
     * @param string $value
     */
    private function validateCardExpiration(string $value): void
    {
        $validator = new Validator\Callback(function ($value) {
            if (preg_match('/^(?P<month>\d{2})\/(?P<year>\d{2})$/', $value, $matches)) {
                $month = $matches['month'];
                if (1 <= $month && $month <= 12) {
                    return true;
                }
            }
            return false;
        });
        $validator->setMessage('Card expiration should be in \'mm/yy\' format');

        if (!$validator->isValid($value)) {
            $this->errors[self::CARD_EXPIRATION] = $this->collectErrors($validator);
        }
    }

    /**
     * @param string $value
     */
    private function validateCvv(string $value): void
    {
        $validator = new Validator\Regex(['pattern' => '/^\d{3}$/']);
        $validator->setMessage('CVV should be number consist of 3 digits');

        if (!$validator->isValid($value)) {
            $this->errors[self::CVV] = $this->collectErrors($validator);
        }
    }

    /**
     * @param string $value
     */
    private function validateOrderNumber(string $value): void
    {
        $validator = new Validator\StringLength(['min' => 16, 'max' => 16]);
        $validator->setMessage('Order number should be string of length 16 characters');

        if (!$validator->isValid($value)) {
            $this->errors[self::ORDER_NUMBER] = $this->collectErrors($validator);
        }
    }

    /**
     * @param string $value
     */
    private function validateSum(string $value): void
    {
        $validator = new Validator\Regex(['pattern' => '/^\d+(,\d{1,2})?$/']);
        $validator->setMessage('Sum should be a float with comma as separator');

        if (!$validator->isValid($value)) {
            $this->errors[self::SUM] = $this->collectErrors($validator);
        } else {
            $this->sum = (float) strtr($this->sum, ',', '.');
        }
    }

    /**
     * @param \Laminas\Validator\ValidatorInterface $validator
     * @return array
     */
    private function collectErrors(Validator\ValidatorInterface $validator): array
    {
        $errors = [];
        foreach ($validator->getMessages() as $message) {
            $errors[] = $message;
        }

        return $errors;
    }
}
