<?php
declare(strict_types=1);

namespace App\Validator;

use App\Validator\Rule\NotBlankHandler;
use App\Validator\Rule\EmailHandler;

/**
 * Class ValidatorFactory
 */
final class ValidatorFactory
{
    /**
     * @return Validator
     */
    public static function create(): Validator
    {
        $ruleHandlerRegistry = new RuleHandlerRegistry([
            new NotBlankHandler(),
            new EmailHandler(),
        ]);

        return new Validator($ruleHandlerRegistry);
    }
}
