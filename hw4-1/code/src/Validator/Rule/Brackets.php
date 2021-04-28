<?php
declare(strict_types=1);

namespace App\Validator\Rule;

use App\Validator\RuleInterface;

/**
 * Class Brackets
 */
final class Brackets implements RuleInterface
{
    /**
     * @param string $message
     */
    public function __construct(
        public string $message = 'Brackets are invalid'
    ) {
    }
}
