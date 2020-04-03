<?php

declare(strict_types=1);

use App\Validators\TicketBookingValidator;
use PHPUnit\Framework\TestCase;

final class TicketBookingValidatorTest extends TestCase
{
    /**
     * @var TicketBookingValidator
     */
    private $validator;

    public function setUp(): void
    {
        $this->validator = new TicketBookingValidator();
    }

    public function testValueIsValid()
    {
        $value = true;
        $this->assertTrue($this->validator->validate($value));

    }
}
