<?php
declare(strict_types=1);

namespace App\Validator;

use App\Validator\Rule\BracketsHandler;
use App\Validator\Rule\NotBlankHandler;

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
            new BracketsHandler(),
        ]);

        return new Validator($ruleHandlerRegistry);
    }
}
