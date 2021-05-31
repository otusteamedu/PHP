<?php
declare(strict_types=1);

namespace App\DTOs;

interface DTOInterface
{
    /**
     * @return bool
     */
    public function validate(): bool;
}
