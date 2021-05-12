<?php
declare(strict_types=1);

namespace App\Validator\Rule;

use App\Validator\RuleInterface;

/**
 * Class Email
 */
final class Email implements RuleInterface
{
    /**
     * @param string $message
     */
    public function __construct(
        public string $message = 'Email address is invalid'
    ) {
    }
}
