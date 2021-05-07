<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class NoConditionsOrNameInEvent extends BadRequestException
{
    /**
     * NoConditionsOrNameInEvent constructor.
     *
     * @param string $message
     */
    #[Pure]
    public function __construct($message = "No conditions data about in event specified or there is not event name! No pivot data is saved!")
    {
        parent::__construct($message);
    }
}
