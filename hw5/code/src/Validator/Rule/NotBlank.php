<?php
declare(strict_types=1);

namespace App\Validator\Rule;

use App\Validator\RuleInterface;

/**
 * Class NotBlank
 */
final class NotBlank implements RuleInterface
{
    /**
     * @param string $message
     */
    public function __construct(
        public string $message = 'Value should not be blank'
    ) {
    }
}
