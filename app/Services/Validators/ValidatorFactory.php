<?php


namespace app\Services\Validators;


use app\Http\Response\Email\ValidatorResponse;
use app\Services\Validators\Email\EmailValidator;
use app\Exceptions\Validator\BadValidatorException;

class ValidatorFactory
{
    /**
     * Фабрика создания конкретного Валидатора.
     * Реализованы следующие Валидаторы:
     * EmailValidator;
     *
     * @param string $validatorType - селектор для выбора типа Валидатора.
     * @return AbstractValidator
     * @throws BadValidatorException
     */
    public static function factory(string $validatorType): AbstractValidator
    {
        return match ($validatorType) {
            EmailValidator::VALIDATOR_NAME => new EmailValidator(),
            default => throw new BadValidatorException("Validator '$validatorType' Not Found. Check configuration file", ValidatorResponse::BAD_VALIDATOR)
        };
    }


}