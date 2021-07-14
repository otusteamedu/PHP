<?php


namespace App\EmailValidator;


use App\Exceptions\AppException;

class ValidatorFactory
{
    /**
     * @return EmailValidator
     * @throws AppException
     */
    public static function factory()
    {
        switch ($_ENV['BASE_EMAIL_VALIDATOR']) {
            case EmailValidator::VALIDATOR_NAME:
                return new EmailValidator();
            default:
                throw new AppException('Валидатор не найден');
        }
    }
}